<?php

namespace App\Models;

use CodeIgniter\Model;

class MenadzerModel extends Model
{
    protected $table      = 'menadzer';
    protected $primaryKey = 'idKor';
    protected $returnType = 'object';
    protected $allowedFields = ['idKor' , 'prosecna_ocena' , 'broj_glasova', 'status_menadzera'];

    public function getManagersByUsername($username) {
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->where('korisnik.korisnicko_ime' , $username)->get()->getResult();
    }
    
    public function getAllManagers() {
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->get()->getResult();
    }
    
    public function getManagersByPartialUsername($username) {
        $username = '%'.$username.'%';
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->like("korisnicko_ime", $username)->get()->getResult();
    }
    
    public function getOpenConcurForManager($username) {
        $db = \Config\Database::connect();
        return $db->table('menadzer')->join('korisnik', 'korisnik.idKor = menadzer.idKor')->join('konkurs', 'konkurs.idMen = korisnik.idKor')->where('korisnik.korisnicko_ime' , $username)->where('konkurs.status_konkursa', 'Otvoren')->get()->getResult();
    }
    
}