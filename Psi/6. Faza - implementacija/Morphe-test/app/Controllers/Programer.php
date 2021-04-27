<?php

namespace App\Controllers;

use App\Models\PrijavioSeNaKonkursModel;
use App\Models\KonkursModel;
use App\Models\ProgramerModel;
use App\Models\PozvanNaKonkursModel;

class Programer extends UserUnspecificControler{

    public function index($konkursi = null, $izbaciKonkurse= null , $poruka = null, $greska = null) {
        return view('programmer-pages/home' , [
            'konkursi' => $konkursi, 
            'izbaciKonkurse'=> $izbaciKonkurse,
            'poruka' => $poruka,
            'greska' => $greska
        ]);
    }
    
    public function project() {
        return "Project page";
    }
    
    public function chat() {
        return "Chat page";
    }
    
    public function pretrazaKonkursa() {
        $programskiJezik = $this->request->getVar('programskiJezik');
        
        $konkursModel = new KonkursModel();
        $konkursi = $konkursModel->getActiveConcursForLanguageForProgramer($programskiJezik, $this->session->get('username'));
        
        $izbaciKonkurse = [];
        
        $projavioModel = new PrijavioSeNaKonkursModel();
        $konkursiPrijavioSe = $projavioModel->getAllAppliedConcursesFromProgramer($this->session->get('username'));
        
        foreach ($konkursiPrijavioSe as $konkurs) {
            array_push($izbaciKonkurse , $konkurs->idKon);
        }
        
        $pozvanModel = new PozvanNaKonkursModel();
        $pozvaniKonkursi = $pozvanModel->getAllConcursesForProgramer($this->session->get('username'));
        
        
        foreach ($pozvaniKonkursi as $konkurs) {
            array_push($izbaciKonkurse , $konkurs->idKon);
        }
        

        return $this->index($konkursi , $izbaciKonkurse);
    }
    
    public function prijaviSeNaKonkurs($idKon) {
        $konkursModel = new KonkursModel();
        $konkurs = $konkursModel->find($idKon);
        if ($konkurs == null || $konkurs->status_konkursa != 'Otvoren') {
            return $this->index(null , null ,null, 'Nije se moguce prijaviti na konkurs');
        }
        
        $prijavaNaKonkurs = new PrijavioSeNaKonkursModel();
        if ($prijavaNaKonkurs->checkIfUserAppliedOnConcurs($this->session->get('username'), $idKon)) {
            return $this->index(null , null , null, 'Vec ste se prijavili na ovaj konkurs');
        }
        
        $programerModel = new ProgramerModel();
        $programerJa = $programerModel->getProgramersByUsername($this->session->get('username'))[0];
        
        $pozvanNaKonkursModel = new PozvanNaKonkursModel();
        $programeri = $pozvanNaKonkursModel->getProgramersWhoGotInvatation($idKon);
        
        $pozvan = false;
        
        foreach ($programeri as $programer) {
            if ($programer->idPro == $programerJa->idKor) {
                $pozvan = true;
                break;
            }
        }
        
        if ($pozvan) {
             return $this->index(null , null ,null, 'Pozvani ste na ovaj konkurs');
        }
        
        $prijava = [
            'idPro' => $programerJa->idKor,
            'idKon' => $idKon,
            'status_prijave' => 'Otvoren'
        ];
        
        $prijavaNaKonkurs->insert($prijava);
        
        return $this->index(null ,null, "Uspesno ste se prijavi na konkurs" , null);
        
    }
       
}
