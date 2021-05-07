<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramerRadiNaModel extends Model
{
    protected $table      = 'programer_radi_na';
    protected $primaryKey = 'idProgramera,idProjekta';
    protected $returnType = 'object';
    protected $allowedFields = ['idProgramera', 'idProjekta' ,'status'];
    
}