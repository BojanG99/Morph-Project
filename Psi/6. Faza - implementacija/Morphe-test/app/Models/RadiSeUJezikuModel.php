<?php

namespace App\Models;

use CodeIgniter\Model;

class RadiSeUJezikuModel extends Model
{
    protected $table      = 'radi_se_u_jeziku';
    protected $primaryKey = 'idKon,idJez';
    protected $returnType = 'object';
    protected $allowedFields = ['idKon', 'idJez' ];
    
}