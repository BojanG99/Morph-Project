<?php

namespace App\Models;

use CodeIgniter\Model;

class VremeNaProjektuModel extends Model
{
    protected $table      = 'vreme_na_projektu';
    protected $primaryKey = 'idVre';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idVre', 'idProjekta' , 'idProgramera', 'vreme_pocetka' , 'vreme_kraja' ];
    
    public function getTimeSpentForProgramer($username) {
        $db = \Config\Database::connect();
        return $db->table('vreme_na_projektu')->join('programer' , 'programer.idKor = vreme_na_projektu.idProgramera')->join('korisnik' , 'korisnik.idKor = programer.idKor')->select('sum(TIMESTAMPDIFF(SECOND,vreme_na_projektu.vreme_pocetka,vreme_na_projektu.vreme_kraja)) as ukupnoVreme')->where('korisnik.korisnicko_ime ', $username)->get()->getResult();
    }
    
}