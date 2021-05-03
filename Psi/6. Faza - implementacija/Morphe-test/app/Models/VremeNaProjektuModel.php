<?php

namespace App\Models;

use CodeIgniter\Model;

class VremeNaProjektuModel extends Model
{
    protected $table      = 'vreme_na_projektu';
    protected $primaryKey = 'idVre';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idVre', 'idProjekta' , 'idProgramera', 'vreme_pocetka' , 'vreme_kraja' ];
    
}