<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table      = 'admin';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor' ];

    public function getAdminsByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('admin')->join('korisnik', 'korisnik.idKor = admin.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    public function getAllAdmins() {
        $db = \Config\Database::connect();
        return $db->table('admin')->join('korisnik', 'korisnik.idKor = admin.idKor')->get()->getResult();
    }
    
}