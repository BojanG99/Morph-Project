<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramskiJezikModel extends Model
{
    protected $table      = 'programski_jezik';
    protected $primaryKey = 'idPro';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = [ 'naziv' ];
   
    public function getProgrammingLanguagesByPartialName($name) {
        $name = '%'.$name.'%';
        $db = \Config\Database::connect();
        return $db->table('programski_jezik')->like("naziv", $name)->get()->getResult();
    }
}