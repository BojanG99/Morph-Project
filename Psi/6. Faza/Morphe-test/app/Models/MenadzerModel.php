<?php
//<!-- Nenad Markovic, Julia Milic, Bojan Galic, Vlade Vulovic --!>

namespace App\Models;

use CodeIgniter\Model;

class MenadzerModel extends Model
{
    protected $table      = 'menadzer';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor' , 'prosecna_ocena' , 'broj_glasova', 'status_menadzera'];

    public function getManagersByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    public function getManagerById($id){
           $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->where("korisnik.idKor",$id)->get()->getResult();
  
    }
    public function getAllManagers() {
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->get()->getResult();
    }
    
    public function getManagersByPartialUsername($username) {
        $username = '%'.$username.'%';
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->like("korisnicko_ime", $username)->get()->getResult();
    }
    
    public function getOpenConcurForManager($username) {
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->join('konkurs', 'konkurs.idMen = korisnik.idKor')->where('korisnik.korisnicko_ime' , $username)->where('konkurs.status_konkursa', 'Otvoren')->get()->getResult();
    }
    
    public function getProjectFotManager($username){
        $db= \Config\Database::connect();
        return $db->table("menadzer")->join("menadzer_vodi_projekat", "menadzer.idKor=menadzer_vodi_projekat.idMen")->join("projekat","projekat.idPro=menadzer_vodi_projekat.idProjekta")->join("korisnik","korisnik.idKor=menadzer.idKor")->join("programer_radi_na","programer_radi_na.idProjekta=projekat.idPro")->where("korisnik.korisnicko_ime",$username)->get()->getResult();
        
    }
    
    public function getActiveProjectFotManager($username){
        $db= \Config\Database::connect();
        return $db->table("menadzer")->join("menadzer_vodi_projekat", "menadzer.idKor=menadzer_vodi_projekat.idMen")->join("projekat","projekat.idPro=menadzer_vodi_projekat.idProjekta")->join("korisnik","korisnik.idKor=menadzer.idKor")->join("programer_radi_na","programer_radi_na.idProjekta=projekat.idPro")->where("korisnik.korisnicko_ime",$username)->where('projekat.status','Aktivan')->get()->getResult();
        
    }
    
      public function getProjectForManagerID($id){
        $db= \Config\Database::connect();
        return $db->table("menadzer")->join("menadzer_vodi_projekat", "menadzer.idKor=menadzer_vodi_projekat.idMen")->join("projekat","projekat.idPro=menadzer_vodi_projekat.idProjekta")->join("korisnik","korisnik.idKor=menadzer.idKor")->join("programer_radi_na","programer_radi_na.idProjekta=projekat.idPro")->where("korisnik.idKor",$id)->get()->getResult();
        
    }
    public function getManagerForProject($idPro){
          $db= \Config\Database::connect();
        return $db->table("menadzer")->join("menadzer_vodi_projekat", "menadzer.idKor=menadzer_vodi_projekat.idMen")->join("projekat","projekat.idPro=menadzer_vodi_projekat.idProjekta")->join("korisnik","korisnik.idKor=menadzer.idKor")->where("projekat.idPro",$idPro)->get()->getResult();
        
        
    }
    
     public function getProjectForManager($men) {
        $db = \Config\Database::connect();
        return $db->table('projekat')->join('menadzer_vodi_projekat', 'menadzer_vodi_projekat.idProjekta = projekat.idPro')->where('menadzer_vodi_projekat.idMen' , $men)->get()->getResult();
    }
}