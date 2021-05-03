<?php

namespace App\Models;

use CodeIgniter\Model;

class CaskanjeModel extends Model
{
    protected $table      = 'caskanje';
    protected $primaryKey = 'idKli,idMen';
    protected $returnType = 'object';
    protected $allowedFields = ['idKli', 'idMen' ];
    
}