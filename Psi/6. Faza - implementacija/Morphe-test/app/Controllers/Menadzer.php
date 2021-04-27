<?php

namespace App\Controllers;

use App\Models\ProgramerModel;
use App\Models\MenadzerModel;
use App\Models\KonkursModel;
use App\Models\PozvanNaKonkursModel;

class Menadzer extends UserUnspecificControler{

    public function index($programeri = null, $haveActiveConrus = null,$listaPozvanihProgramera = null , $poruka = null , $greska = null) {
        return view('manager-pages/home' , [
            'programeri' => $programeri,
            'listaPozvanihProgramera' => $listaPozvanihProgramera,
            'moguDaPosaljemPozivnice' => $haveActiveConrus,
            'greska' => $greska , 
            'poruka' => $poruka
        ]);
    }
    
    public function project() {
        return "Project page";
    }
    
    public function chat() {
        return "Chat page";
    }
    
    public function pretraziProgramere() {
        $usernameProgramera = $this->request->getVar('nazivProgramera');
        $sortiraj = $this->request->getVar('sortitajProgramere');
        
        $model = new ProgramerModel();
        $programeri = $model->getProgramersByPartialUsername($usernameProgramera);
        
        $menadzerModel = new MenadzerModel();
        $otvoreniKonkursi = $menadzerModel->getOpenConcurForManager($this->session->get('username'));
        $moguDaPosalje = (count($otvoreniKonkursi) != 0);
        
        
        if ($sortiraj == "Sortiraj po oceni rastuce") {
            usort($programeri, function($a , $b) {
                return $a->prosecna_ocena > $b->prosecna_ocena;
            });
        }
        else if($sortiraj == "Sortiraj po oceni opadajuce") {
            usort($programeri, function($a , $b) {
                return $a->prosecna_ocena < $b->prosecna_ocena;
            });
        }else if ($sortiraj == "Sortiraj po korisnickom imenu rastuce") {
            usort($programeri, function($a , $b) {
                return $a->korisnicko_ime > $b->korisnicko_ime;
            });
        }else if ($sortiraj == "Sortiraj po korisnickom imenu opadajuce") {
            usort($programeri, function($a , $b) {
                return $a->korisnicko_ime < $b->korisnicko_ime;
            });
        }
        $listaPozvanihProgramera = [];
        if ($moguDaPosalje) {
            $pozvanModel = new PozvanNaKonkursModel();
            $listaProgramera = $pozvanModel->getProgramersWhoGotInvatation($otvoreniKonkursi[0]->idKon);
            foreach ($listaProgramera as $programer) {
                array_push($listaPozvanihProgramera , $programer->idPro);
            }
        }
        
        return $this->index($programeri, $moguDaPosalje, $listaPozvanihProgramera);
    }
    
    
    public function sendInvatation($username) {
        $konkursModel = new KonkursModel();
        $konkursi = $konkursModel->getActiveConcursIfExistsForManager($this->session->get('username'));
        if (count($konkursi) != 1 && $konkursi[0]->status_konkursa != 'Otvoren') {
            return $this->index(null , null , null ,null , 'Pokusali ste pozvati pozivnicu, a niste otvorili konkurs!');
        }
        
        $programerModel = new ProgramerModel();
        $programeri = $programerModel->getProgramersByUsername($username);
        $brojProgramera = count($programeri);
        
        if ($brojProgramera != 1) {
            return $this->index(null , null , null ,null , 'Pokusali ste pozvati pozivnicu, nekom ko nije programer!');
        } 
        
        $pozvanModel = new PozvanNaKonkursModel();
        $gotInvavation = $pozvanModel->checkIfUserGotInvatation($username, $konkursi[0]->idKon);
                
        if ($gotInvavation) {
            return $this->index(null , null , null ,null , 'Pokusali ste pozvati pozivnicu, nekom ko je vec dobio pozivnicu!');
        }
        $data = [
            'idPro' => $programeri[0]->idKor,
            'idKon' => $konkursi[0]->idKon,
            'status_prijave' => 'Otvoren'
        ];
        $pozvanModel->insert($data);
 
        
        return $this->index(null , null ,null , 'Uspesno ste poslali pozivnicu' );
    }
       
       
}
