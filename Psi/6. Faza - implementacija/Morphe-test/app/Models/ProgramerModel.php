<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramerModel extends Model
{
    protected $table      = 'programer';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor' , 'prosecna_ocena' , 'broj_glasova', 'status_programera', 'cv_URL'];
    
    public function getProgramersByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('programer')->join('korisnik', 'korisnik.idKor = programer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    public function getAllProgramers() {
        $db = \Config\Database::connect();
        return $db->table('programer')->join('korisnik', 'korisnik.idKor = programer.idKor')->get()->getResult();
    }

}