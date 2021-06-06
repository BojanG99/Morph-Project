<?php
//<!-- Vlade Vulovic -->

namespace App\Models;

use CodeIgniter\Model;

class KlijentProjekatModel extends Model
{
    protected $table      = 'klijent_projekat';
    protected $primaryKey = 'idProjekta,idKli';
    protected $returnType = 'object';
    protected $allowedFields = ['idProjekta','idKli','status'];

    public function getFinishedProject($klijentId) {
        $db = \Config\Database::connect();
        return $db->table('klijent_projekat')->where('klijent_projekat.idKli' , $klijentId)->where('klijent_projekat.status',"Zavrsen")->get()->getResult();
    }
    
   public function getRunningProject($klijentId) {
        $db = \Config\Database::connect();
        return $db->table('klijent_projekat')->where('klijent_projekat.idKli' , $klijentId)->where('klijent_projekat.status',"Implementacija")->get()->getResult();
    }
    
    public function getClientForProject($idPro){
        
          $db = \Config\Database::connect();
        return $db->table('klijent_projekat')->where('klijent_projekat.idProjekta' , $idPro)->where('klijent_projekat.status',"Implementacija")->get()->getResult();
 
    }
    
}