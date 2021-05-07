<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjekatModel extends Model
{
    protected $table      = 'projekat';
    protected $primaryKey = 'idPro';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idPro', 'idKon' , 'putanja_u_fajl_sistemu' ];
    
    public function getAllProjectsForProgramer($username) {
        $db = \Config\Database::connect();
        return $db->table('projekat')->join('programer_radi_na', 'programer_radi_na.idProjekta = projekat.idPro')->join('programer', 'programer.idKor = programer_radi_na.idProgramera')->join('korisnik', 'korisnik.idKor = programer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    public function getAllProjectsForManager($username) {
        $db = \Config\Database::connect();
        return $db->table('projekat')->join('konkurs', 'projekat.idKon = konkurs.idKon')->join('menadzer', 'konkurs.idMen = menadzer.idKor')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
}