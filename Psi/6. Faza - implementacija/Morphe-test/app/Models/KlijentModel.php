<?php

namespace App\Models;

use CodeIgniter\Model;

class KlijentModel extends Model
{
    protected $table      = 'klijent';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor'];

    public function getClientsByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('klijent')->join('korisnik', 'korisnik.idKor = klijent.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    public function getAllClients() {
        $db = \Config\Database::connect();
        return $db->table('klijent')->join('korisnik', 'korisnik.idKor = klijent.idKor')->get()->getResult();
    }
    
    
}