<?php

namespace App\Models;

use CodeIgniter\Model;

class KonkursModel extends Model
{
    protected $table      = 'konkurs';
    protected $primaryKey = 'idKon';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['idKon' , 'idMen' , 'opis' , 'vreme_pocetka', 'vreme_kraja', 'status_konkursa'];
    // zameniti
    public function getActiveConcursForLanguage($jezik) {
        $jezik = '%'.$jezik.'%';
        $db = \Config\Database::connect();
        $konkursi = $db->table('konkurs')->join('radi_se_u_jeziku' , 'radi_se_u_jeziku.idKon = konkurs.idKon')->join('programski_jezik', 'radi_se_u_jeziku.idJez = programski_jezik.idPro')->join('menadzer', 'konkurs.idMen = menadzer.idKor')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->where('status_konkursa', 'Otvoren')->like("naziv", $jezik)->groupBy("konkurs.idKon")->get()->getResult();
        foreach($konkursi as $konkurs) {
            $jezikString = "";
            $listaJezik = $db->table('konkurs')->join('radi_se_u_jeziku', 'radi_se_u_jeziku.idKon = konkurs.idKon')->join('programski_jezik', 'programski_jezik.idPro = radi_se_u_jeziku.idJez')->select('programski_jezik.naziv')->where('konkurs.idKon', $konkurs->idKon)->get()->getResult();
            foreach ($listaJezik as $jezik) {
                if ($jezikString == "") $jezikString = $jezik->naziv;
                else $jezikString = $jezikString.','.$jezik->naziv;
            }
            $konkurs->naziv = $jezikString;
        }
        return $konkursi;
    }
    
    public function getActiveConcursIfExistsForManager($username) {
        $db = \Config\Database::connect();
        return $db->table('konkurs')->join('korisnik' , 'korisnik.idKor = konkurs.idMen')->where('status_konkursa', 'Otvoren')->where('korisnik.korisnicko_ime ', $username)->get()->getResult();
    }
    
}