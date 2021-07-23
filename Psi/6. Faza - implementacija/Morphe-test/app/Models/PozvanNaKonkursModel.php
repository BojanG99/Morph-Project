<?php

namespace App\Models;

use CodeIgniter\Model;

class PozvanNaKonkursModel extends Model
{
    protected $table      = 'pozvan_na_konkurs';
    protected $primaryKey = 'idPro,idKon';
    protected $returnType = 'object';
    protected $allowedFields = [ 'idPro' , 'idKon', 'status_prijave' ];
    
    public function checkIfUserGotInvatation($username, $idKon) {
        $db = \Config\Database::connect();
        $listaPrijava = $db->table('pozvan_na_konkurs')->join('korisnik', 'pozvan_na_konkurs.idPro = korisnik.idKor')->join('konkurs' , 'konkurs.idKon = pozvan_na_konkurs.idKon')->where('korisnik.korisnicko_ime', $username)->where('konkurs.idKon', $idKon)->get()->getResult();
        return count($listaPrijava ) != 0;
    }
    
    public function getProgramersWhoGotInvatation($idKon) {
        $db = \Config\Database::connect();
        return $db->table('pozvan_na_konkurs')->select('pozvan_na_konkurs.idPro')->where('pozvan_na_konkurs.idKon' , $idKon)->get()->getResult();
    }
    
    public function getAllConcursesForProgramer($username) {
         $db = \Config\Database::connect();
         return $db->table('pozvan_na_konkurs')->join('korisnik', 'pozvan_na_konkurs.idPro = korisnik.idKor')->where('korisnik.korisnicko_ime', $username)->get()->getResult();
    }
   
}