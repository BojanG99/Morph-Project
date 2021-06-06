<?php
//<!-- Nenad Markovic, Julia Milic, Bojan Galic, Vlade Vulovic --!>

namespace App\Models;

use CodeIgniter\Model;

class MenadzerVodiProjekatModel extends Model
{
    protected $table      = 'menadzer_vodi_projekat';
    protected $primaryKey = 'idProjekta, idMen';
    protected $returnType = 'object';
    protected $allowedFields = ['idProjekta', 'idMen' ];
    
    
    public function getManagersProjectsById($managerId) {
        $db = \Config\Database::connect();
        return $db->table('menadzer_vodi_projekat')->where('idMen' , $managerId)->where('status','Aktivan')->get()->getResult();
    }

}