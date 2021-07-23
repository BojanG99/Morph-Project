<?php

namespace App\Models;

use CodeIgniter\Model;

class PorukaModel extends Model
{
    protected $table      = 'poruka';
    protected $primaryKey = 'idPor';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idPor', 'idKli' , 'idMen' , 'tekst' , 'status_poruke', 'poslata_od' , 'datum_vreme_slanja'];
    
}