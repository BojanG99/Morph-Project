<?php
//<!-- Bojan Galic --!>

namespace App\Models;

use CodeIgniter\Model;

class PrijavioSeNaKonkursModel extends Model
{
    protected $table      = 'prijavio_se_na_konkurs';
    protected $primaryKey = 'idPro,idKon';
    protected $returnType = 'object';
    protected $allowedFields = [ 'idPro' , 'idKon', 'status_prijave' ];
   
    public function checkIfUserAppliedOnConcurs($username , $idKon) {
        $db = \Config\Database::connect();
        $listaPrijava = $db->table('prijavio_se_na_konkurs')->join('korisnik', 'prijavio_se_na_konkurs.idPro = korisnik.idKor')->join('konkurs' , 'konkurs.idKon = prijavio_se_na_konkurs.idKon')->where('korisnik.korisnicko_ime', $username)->where('konkurs.idKon', $idKon)->get()->getResult();
        return count($listaPrijava ) != 0;
    }
    
    public function getAllAppliedConcursesFromProgramer($username) {
         $db = \Config\Database::connect();
         return $db->table('prijavio_se_na_konkurs')->join('korisnik', 'prijavio_se_na_konkurs.idPro = korisnik.idKor')->where('korisnik.korisnicko_ime', $username)->get()->getResult();
    }
}