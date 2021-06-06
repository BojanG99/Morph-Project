<?php
//<!-- Bojan Galic, Nenad Markovic --!>

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
    public function dohvatiProjekat($userid){
     $db = \Config\Database::connect();
        return $db->table('programer_radi_na')->where("idProgramera",$userid)->where("status","Aktivan")->get()->getResult();
    }

    public function dohvatiAktivanProjekatZaMenadzera($idMen){
           $db = \Config\Database::connect();
            return $db->table("menadzer_vodi_projekat")->join("projekat", "menadzer_vodi_projekat.idProjekta=projekat.idPro")->where("menadzer_vodi_projekat.idMen",$idMen)->
                    where("menadzer_vodi_projekat.status","aktivan")->where('projekat.status','Aktivan')->get()->getResult();
         
    }
    
    public function getAllTasksForPoject($project){
        $db = \Config\Database::connect();
            return $db->table("zadatak")->join("korisnik", "zadatak.idProgramera=korisnik.idKor")->where("idProjekta",$project)->get()->getResult();
    }
        

    public function getProjectForClient($id){
         $db = \Config\Database::connect();
            return $db->table("klijent_projekat")->join("projekat", "klijent_projekat.idProjekta=projekat.idPro")->where("klijent_projekat.idKli",$id)->get()->getResult();
         
    }
    
    public function getActiveProjectForClient($id){
         $db = \Config\Database::connect();
            return $db->table("klijent_projekat")->join("projekat", "klijent_projekat.idProjekta=projekat.idPro")->where("klijent_projekat.idKli",$id)->where('projekat.status','Aktivan')->get()->getResult();
         
    }

   public function getProjectForManagerUname($uname){
    $db = \Config\Database::connect();
    return $db->table("menadzer_vodi_projekat")->join("projekat", "menadzer_vodi_projekat.idProjekta=projekat.idPro")->join('korisnik','menadzer_vodi_projekat.idMen=korisnik.idKor')->where("korisnik.korisnicko_ime",$uname)->get()->getResult();
}

public function getActiveProjectForManagerUname($uname){
    $db = \Config\Database::connect();
    return $db->table("menadzer_vodi_projekat")->join("projekat", "menadzer_vodi_projekat.idProjekta=projekat.idPro")->join('korisnik','menadzer_vodi_projekat.idMen=korisnik.idKor')->where("korisnik.korisnicko_ime",$uname)->where('projekat.status','Aktivan')->get()->getResult();
}

    
    public function getProgramersForProject($idProjekta){
     
        $db = \Config\Database::connect();
        return $db->table('programer_radi_na')->join('programer','programer.idKor=programer_radi_na.idProgramera')->where("idProjekta",$idProjekta)->where("status","Aktivan")->get()->getResult();
    }    
    
    
    
     public function updateMenProject($idMen,$idPro,$status){
        
           $db = \Config\Database::connect();
        return $db->table('menadzer_vodi_projekat')->set('status', $status)->where('idProjekta', $idPro)->where('idMen', $idMen)->update();
    }
    
      public function updateCliProject($idKli,$idPro,$status){

          $db = \Config\Database::connect();
        return $db->table('klijent_projekat')->set('status', $status)->where('idProjekta', $idPro)->where('idKli', $idKli)->update();
    }
    
    public function updateStatus($idPro,$status)
    {
        $db = \Config\Database::connect();
        return $db->table('projekat')->set('status', $status)->where('idPro', $idPro)->update();
    }
}