<?php

namespace App\Controllers;

use App\Models\MenadzerModel;
use App\Models\KlijentModel;

class Klijent extends UserUnspecificControler{

    public function index($menadzeri = null) {
        return view('client-pages/home' , ['menadzeri' => $menadzeri]);
    }
    
    public function project() {
        return "Project page";
    }
    
    public function chat($username = null) {
        if ($username == null) {
            return "Svi razgovori";
        }
        
        return "Razgovori za klijenta sa $username";
    }
    
    public function myProfile() {
        
        $model = new KlijentModel();
        $klijent = $model->getClientsByUsername($this->session->get('username'))[0];
        
        $greska = $this->session->get('greska');
        $poruka = $this->session->get('poruka');
        
        $this->session->set('greska', null);
        $this->session->set('poruka', null);
        
        return view('client-pages/profile', [
            'klijent' => $klijent,
            'myProfile' => true,
            'greska' => $greska,
            'poruka' => $poruka
        ]);
    }
    
    
    public function pretraziMenadzere() {
        $usernameMenadzera = $this->request->getVar('nazivMenadzera');
        $sortiraj = $this->request->getVar('sortitajMenadzere');
        
        $model = new MenadzerModel();
        $menadzeri = $model->getManagersByPartialUsername($usernameMenadzera);
        
        if ($sortiraj == "Sortiraj po oceni rastuce") {
            usort($menadzeri, function($a , $b) {
                return $a->prosecna_ocena > $b->prosecna_ocena;
            });
        }
        else if($sortiraj == "Sortiraj po oceni opadajuce") {
            usort($menadzeri, function($a , $b) {
                return $a->prosecna_ocena < $b->prosecna_ocena;
            });
        }else if ($sortiraj == "Sortiraj po korisnickom imenu rastuce") {
            usort($menadzeri, function($a , $b) {
                return $a->korisnicko_ime > $b->korisnicko_ime;
            });
        }else if ($sortiraj == "Sortiraj po korisnickom imenu opadajuce") {
            usort($menadzeri, function($a , $b) {
                return $a->korisnicko_ime < $b->korisnicko_ime;
            });
        }
        
        return $this->index($menadzeri);
    }
       
}
