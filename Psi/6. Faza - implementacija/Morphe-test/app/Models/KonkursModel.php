<?php

namespace App\Models;

use CodeIgniter\Model;

class KonkursModel extends Model
{
    protected $table      = 'konkurs';
    protected $primaryKey = 'idKon';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['idKon','idJez' , 'idMen' , 'opis' , 'vreme_pocetka', 'vreme_kraja', 'status_konkursa'];
    
    public function getActiveConcursForLanguage($jezik) {
        $jezik = '%'.$jezik.'%';
        $db = \Config\Database::connect();
        return $db->table('konkurs')->join('korisnik' , 'korisnik.idKor = konkurs.idMen')->join('programski_jezik', 'konkurs.idJez = programski_jezik.idPro')->where('status_konkursa', 'Otvoren')->like("naziv", $jezik)->get()->getResult();
    }
    
    public function getActiveConcursForLanguageForProgramer($jezik, $username) {
        $jezik = '%'.$jezik.'%';
        $db = \Config\Database::connect();
        return $db->table('konkurs')->join('korisnik' , 'korisnik.idKor = konkurs.idMen')->join('programski_jezik', 'konkurs.idJez = programski_jezik.idPro')->where('status_konkursa', 'Otvoren')->where('korisnik.korisnicko_ime != ', $username)->like("naziv", $jezik)->get()->getResult();
    }
    
    public function getActiveConcursIfExistsForManager($username) {
        $db = \Config\Database::connect();
        return $db->table('konkurs')->join('korisnik' , 'korisnik.idKor = konkurs.idMen')->where('status_konkursa', 'Otvoren')->where('korisnik.korisnicko_ime ', $username)->get()->getResult();
    }
    
}