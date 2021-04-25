<?php

namespace App\Models;

use CodeIgniter\Model;

class KorisnikNaCekanjuModel extends Model
{
    protected $table      = 'korisniknacekanju';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor' , 'tip'];
    
    public function getAllUsersOnHold() {
        $db = \Config\Database::connect();
        return $db->table('korisniknacekanju')->join('korisnik', 'korisnik.idKor = korisniknacekanju.idKor')->get()->getResult();
    }
    
    public function getUsersOnHoldByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('korisniknacekanju')->join('korisnik', 'korisnik.idKor = korisniknacekanju.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    

}