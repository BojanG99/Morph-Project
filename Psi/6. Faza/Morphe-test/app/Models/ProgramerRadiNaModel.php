<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramerRadiNaModel extends Model
{
    protected $table      = 'programer_radi_na';
    protected $primaryKey = 'idProgramera,idProjekta';
    protected $returnType = 'object';
    protected $allowedFields = ['idProgramera', 'idProjekta' ,'status'];
    
    public function daLiProgramerRadiNaProjektu($username){
         $db = \Config\Database::connect();
         $projekat= $db->table('programer_radi_na')->join('korisnik', 'programer_radi_na.idProgramera = korisnik.idKor')->where('korisnik.korisnicko_ime', $username)->where('programer_radi_na.status','Aktivan')->get()->getResult();
   
        if($projekat==null){
            return false;
        }
        
        return true;
    }
    
}