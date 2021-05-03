<?php

namespace App\Models;

use CodeIgniter\Model;

class KorisnikModel extends Model
{
    protected $table      = 'korisnik';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor', 'korisnicko_ime', 'lozinka' , 'email' , 'broj_telefona', 'slika_URL'];
    
    public function getUsersByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('korisnik')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
}