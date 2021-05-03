<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjekatModel extends Model
{
    protected $table      = 'projekat';
    protected $primaryKey = 'idPro';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idPro', 'idKon' , 'putanja_u_fajl_sistemu' ];
    
}