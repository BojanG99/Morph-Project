<?php
//<!-- Julia Milic --!>

namespace App\Models;

use CodeIgniter\Model;

class PorukaModel extends Model
{
    protected $table      = 'poruka';
    protected $primaryKey = 'idPor';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['idPor', 'idKli' , 'idMen' , 'tekst' , 'status_poruke', 'poslata_od' , 'datum_vreme_slanja'];
    
     /*
    Julia Milic
dohvata poruke za dva korisnika, gde j eprvi argument id menadzera, a drugi id je od klijenta
      *       */
    
      public function pretragaPoruka($id1,$id2) {
        $db = \Config\Database::connect();
        return $db->table('poruka')->join('klijent' , 'klijent.idKor = poruka.idKli')->join('menadzer', 'menadzer.idKor = poruka.idMen')->where('menadzer.idKor',$id1)->where('klijent.idKor',$id2)->get()->getResult();
    }
    
    
    
    
}