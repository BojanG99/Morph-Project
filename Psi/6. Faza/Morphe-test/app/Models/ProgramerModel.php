<?php
//<!-- Julia Milic, Bojan Galic, Nenad Markovic, Vlade Vulovic --!>

namespace App\Models;

use CodeIgniter\Model;

class ProgramerModel extends Model
{
    protected $table      = 'programer';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor' , 'prosecna_ocena' , 'broj_glasova', 'status_programera', 'cv_URL'];
    
    public function getProgramersByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('programer')->join('korisnik', 'korisnik.idKor = programer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    public function getAllProgramers() {
        $db = \Config\Database::connect();
        return $db->table('programer')->join('korisnik', 'korisnik.idKor = programer.idKor')->get()->getResult();
    }
    public function getProgramerById($id){
           $db = \Config\Database::connect();
        return $db->table('programer')->join("korisnik", 'korisnik.idKor = programer.idKor')->where("programer.idKor",$id)->get()->getResult();
    }
    
    public function getProgramersByPartialUsername($username) {
        $username = '%'.$username.'%';
        $db = \Config\Database::connect();
        return $db->table('programer')->join('korisnik', 'korisnik.idKor = programer.idKor')->like("korisnicko_ime", $username)->get()->getResult();
    }
    
    public function getProgramersAppliedToKonkurs($idKon)
    {
         $db = \Config\Database::connect();
         
         return $db->table('programer')->join('prijavio_se_na_konkurs', 'prijavio_se_na_konkurs.idPro = programer.idKor')
                 ->where('prijavio_se_na_konkurs.idKon',$idKon)->get()->getResult();
    }

}