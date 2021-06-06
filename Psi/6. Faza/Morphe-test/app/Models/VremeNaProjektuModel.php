<?php
//<!-- Bojan Galic, Vlade Vulovic --!>

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
        $resualt = $db->table('vreme_na_projektu')->join('programer' , 'programer.idKor = vreme_na_projektu.idProgramera')->join('korisnik' , 'korisnik.idKor = programer.idKor')->select('sum(TIMESTAMPDIFF(SECOND,vreme_na_projektu.vreme_pocetka,vreme_na_projektu.vreme_kraja)) as ukupnoVreme')->where('korisnik.korisnicko_ime', $username)->get()->getResult();
        if ($resualt[0]->ukupnoVreme == null) {
            $resualt[0]->ukupnoVreme = 0;
        }
        return $resualt;
    }
    
    public function addTimeForProgramer($username, $startTime , $endTime) {
        $idPro = 1; // ovde treba dohvatiti idProjekta
        $idProgramera = ((new ProgramerModel())->getProgramersByUsername($username)[0]->idKor);
        $data = [
            'idProjekta' => $idPro,
            'idProgramera' => $idProgramera,
            'vreme_pocetka' => $startTime,
            'vreme_kraja' => $endTime
        ];
        $this->insert($data);
        
    }
    
}