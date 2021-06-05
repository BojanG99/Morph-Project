<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramerRadiNaProjektuModel extends Model
{
    
    protected $table      = 'programer_radi_na';
    protected $primaryKey = ['idProgramera','idProjekta'];
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $allowedFields = [ 'idProgramera','idProjekta','status' ];
    
    
    public function updateProg($idProg,$idPro,$status){
        
           $db = \Config\Database::connect();
        return $db->table('programer_radi_na')->set('status', $status)->where('idProjekta', $idPro)->where('idProgramera', $idProg)->update();
    }
    public function getAllProgramersWorkingOnProject($idProject){
           $db = \Config\Database::connect();
        return $db->table('programer_radi_na')->join('korisnik',"programer_radi_na.idProgramera=korisnik.idKor")->where("programer_radi_na.idProjekta",$idProject)->get()->getResult();
    }
}
