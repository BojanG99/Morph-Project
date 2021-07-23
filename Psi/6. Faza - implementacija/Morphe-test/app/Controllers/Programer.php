<?php

namespace App\Controllers;

use App\Models\PrijavioSeNaKonkursModel;
use App\Models\KonkursModel;
use App\Models\ProjekatModel;
use App\Models\ProgramerModel;
use App\Models\PozvanNaKonkursModel;
use App\Models\ZadatakModel;
use App\Models\VremeNaProjektuModel;



class Programer extends UserUnspecificControler{
    
    protected function convertSecToTime($sec){
	$date1 = new \DateTime("@0"); 
	$date2 = new \DateTime("@$sec"); 
	$interval =  date_diff($date1, $date2); 
	return $interval->format('%yy %mm %dd %h:%i:%s');  // promeni format ako hocete
    }

    public function index($konkursi = null, $izbaciKonkurse= null , $poruka = null, $greska = null) {
        return view('programmer-pages/home' , [
            'konkursi' => $konkursi, 
            'izbaciKonkurse'=> $izbaciKonkurse,
            'poruka' => $poruka,
            'greska' => $greska
        ]);
    }
    
    public function uploadCV() {         
        
        if (isset($_FILES['cvFile']['error']) && $_FILES['cvFile']['error'] != 0) {
            $this->session->set('greska', "Greska prilikom slanja! Fajl je verovatno preveliki! Maksimalna velicina fajl 2MB. ");
            $this->session->set('poruka' , null);
            return redirect()->to(site_url("Programer/myProfile"));
        }
        
        if (isset($_FILES['cvFile']['type']) ) $CvFileType = $_FILES['cvFile']['type'];
        else $CvFileType = "";
        
        if ($CvFileType != "application/pdf" ) {
            $this->session->set('greska', "Greska! CV mora biti mora biti u pdf formatu");
            $this->session->set('poruka' , null);
            return redirect()->to(site_url("Programer/myProfile"));
        }
        
        $username = $this->session->get('username');
        $target_dir = "images/cvs/";
        $target_file = $target_dir. $username . '.' . substr($CvFileType, 12);
        
        if (file_exists($target_file)) {
            if (!unlink($target_file)) {
                $this->session->set('greska', "Greska! Doslo je do greske prilikom uplodovanja file");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
        }
        
        if (move_uploaded_file($_FILES["cvFile"]["tmp_name"], rootDirectory.$target_file)) {
            $model = new ProgramerModel();
            $korisnik = $model->getProgramersByUsername($username)[0];
            $model->update($korisnik->idKor ,['cv_URL' => $target_file]);
   
            $this->session->set('greska', null);
            $this->session->set('poruka' , "Uspesno ste uplodovali CV");
            return redirect()->to(site_url("Programer/myProfile"));
        }
        
        $this->session->set('greska', "Greska! Doslo je do greske prilikom uplodovanja file");
        $this->session->set('poruka' , null);
        return redirect()->to(site_url("Programer/myProfile"));
    }
    
    public function myProfile() {
        
        $model = new ProgramerModel();
        $programer = $model->getProgramersByUsername($this->session->get('username'))[0];
        
        $projekatModel = new ProjekatModel();
        $zadatakModel = new ZadatakModel();
        $vremeNaProjektuModel = new VremeNaProjektuModel();
      
        $brojProjekat = count($projekatModel->getAllProjectsForProgramer($programer->korisnicko_ime));
        $brojZadataka = count($zadatakModel->getAllTasksForProgramer($programer->korisnicko_ime));
        $vreme = $this->convertSecToTime($vremeNaProjektuModel->getTimeSpentForProgramer($programer->korisnicko_ime)[0]->ukupnoVreme);
        
        $greska = $this->session->get('greska');
        $poruka = $this->session->get('poruka');
        
        $this->session->set('greska', null);
        $this->session->set('poruka', null);
        
        return view('programmer-pages/profile', [
            'programer' => $programer,
            'brojProjekata' => $brojProjekat,
            'brojZadataka' => $brojZadataka,
            'vreme' => $vreme,
            'myProfile' => true,
            'greska' =>  $greska, 
            'poruka' =>  $poruka
         ]);
    }
    
    public function project() {
        return "Project page";
    }
    
    public function pretrazaKonkursa() {
        $programskiJezik = $this->request->getVar('programskiJezik');
        
        $konkursModel = new KonkursModel();
        $konkursi = $konkursModel->getActiveConcursForLanguage($programskiJezik);
        
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
