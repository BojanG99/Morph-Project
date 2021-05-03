<?php

namespace App\Models;

use CodeIgniter\Model;

class ZadatakModel extends Model
{
    protected $table      = 'zadatak';
    protected $primaryKey = 'idZad';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idZad', 'idProjekta' , 'idProgramera' , 'opis', 'faza'];
    
}