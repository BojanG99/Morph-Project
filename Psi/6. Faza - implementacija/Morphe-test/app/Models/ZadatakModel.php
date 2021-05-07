<?php

namespace App\Models;

use CodeIgniter\Model;

class ZadatakModel extends Model
{
    protected $table      = 'zadatak';
    protected $primaryKey = 'idZad';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idZad', 'idProjekta' , 'idProgramera' , 'opis', 'faza'];
    
    public function getAllTasksForProgramer($username) {
        $db = \Config\Database::connect();
        return $db->table('zadatak')->join('programer' , 'programer.idKor = zadatak.idProgramera')->join('korisnik', 'korisnik.idKor = programer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
}