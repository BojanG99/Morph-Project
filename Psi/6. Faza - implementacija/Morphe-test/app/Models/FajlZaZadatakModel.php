<?php

namespace App\Models;

use CodeIgniter\Model;

class ZajlZaZadatakModel extends Model
{
    protected $table      = 'fajl_za_zadatak';
    protected $primaryKey = 'idFaj';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idFaj', 'idZad' , 'ime' ];
    
}