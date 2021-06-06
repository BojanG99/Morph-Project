<?php
//<!-- Nenad Markovic, Julia Milic, Bojan Galic, Vlade Vulovic -->

namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model
{
    protected $table      = 'korisnik';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor', 'korisnicko_ime', 'lozinka' , 'email' , 'broj_telefona', 'slika_URL'];
    
    public function getUsersByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('korisnik')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    
    public function getProgramersAppliedToKonkurs($idKon)
    {
         $db = \Config\Database::connect();
         
         return $db->table('korisnik')->join('programer', 'programer.idKor = korisnik.idKor')->join('prijavio_se_na_konkurs', 'prijavio_se_na_konkurs.idPro = programer.idKor')
                 ->where('prijavio_se_na_konkurs.idKon',$idKon)->get()->getResult();
    }
    
}