<?php

namespace App\Models;

use CodeIgniter\Model;

class CaskanjeModel extends Model
{
    protected $table      = 'caskanje';
    protected $primaryKey = 'idCaskanja';
    protected $returnType = 'object';
    protected $allowedFields = ['idCaskanja','idKli', 'idMen' ];
    
    
    public function checkIfExists($idKli,$idMen){
         $db = \Config\Database::connect();
       $ret=$db->table('caskanje')->where('caskanje.idKli',$idKli)->where('caskanje.idMen',$idMen)->get()->getResult();
    if($ret==NULL || count($ret)==0)return false;
    
    return true;
    }
    
    
}