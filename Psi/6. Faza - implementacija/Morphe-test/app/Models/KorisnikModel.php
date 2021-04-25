<?php

namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model
{
    protected $table      = 'korisnik';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['korisnicko_ime', 'lozinka' , 'email' , 'broj_telefona', 'slika_URL'];
    
}