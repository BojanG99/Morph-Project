<?php

namespace App\Controllers;

use App\Models\PrijavioSeNaKonkursModel;
use App\Models\KonkursModel;
use App\Models\KorisnikModel;
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
    
   /* public function uploadPicture() {
        
        if (isset($_FILES['profileFile']['error']) && $_FILES['profileFile']['error'] != 0) {
            $this->session->set('greska', "Greska prilikom slanja! Fajl je verovatno preveliki! Maksimalna velicina fajl 2MB. ");
            $this->session->set('poruka' , null);
            return redirect()->to(site_url("Programer/myProfile"));
        }
        
        if (isset($_FILES['profileFile']['type'])) $imageFileType = $_FILES['profileFile']['type'];
        else $imageFileType = "";
        
        if ($imageFileType != "image/jpg" && $imageFileType != 'image/png' && $imageFileType != 'image/jpeg') {
            $this->session->set('greska', "Greska! Slika mora biti mora biti u jednom od formata: jpg , png , jpeg");
            $this->session->set('poruka' , null);
            return redirect()->to(site_url("Programer/myProfile"));
        }
        
        if(isset($_POST["submit"])) { //neka provera za ispravnosti fajlova
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check === false) {
                    $this->session->set('greska', "Greska! Nesto nije u redu sa slikom koju ste poslali");
                    $this->session->set('poruka' , null);
                    return redirect()->to(site_url("Programer/myProfile"));
                }
        }
        
        $username = $this->session->get('username');
        $target_dir = "images/users-profile-images/";
        $target_file = $target_dir. $username . '.' . substr($imageFileType, 6);
        
        if (file_exists($target_file)) {
            if (!unlink($target_file)) {
                $this->session->set('greska', "Greska! Doslo je do greske prilikom uplodovanja file");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
        }
        
        if (move_uploaded_file($_FILES["profileFile"]["tmp_name"], rootDirectory.$target_file)) {
            $model = new KorisnikModel();
            $korisnik = $model->getUsersByUsername($username)[0];
            $model->update($korisnik->idKor ,['slika_URL' => $target_file]);
            $this->session->set('slika_URL', $target_file);
            $this->session->set('greska', null);
            $this->session->set('poruka' , "Uspesno ste uplodovali sliku");
            return redirect()->to(site_url("Programer/myProfile"));
        }
        
        $this->session->set('greska', "Greska! Doslo je do greske prilikom uplodovanja file");
        $this->session->set('poruka' , null);
        return redirect()->to(site_url("Programer/myProfile"));
    } */
    
    public function myProfile() {
        
        $model = new ProgramerModel();
        $programer = $model->getProgramersByUsername($this->session->get('username'))[0];
        
        $brojProjekat = 0;
        $brojZadataka = 0;
        $vreme = 0;
        
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
    
    public function chat() {
        return "Chat page";
    }
    
 /*   public function changePassword() {
            $username = $this->session->get('username');
            
            $model = new ProgramerModel();
            $korisnici = $model->getProgramersByUsername($username);
            if (count($korisnici) != 1) {
                $this->session->set('greska', "Greska! Korisnik ne postiji");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            $korisnik = $korisnici[0];
            $oldpassword = $this->request->getVar('oldpassword');
            if ($korisnik->lozinka != $oldpassword) {
                $this->session->set('greska', "Greska! Pogresna stara lozinka");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            $newpassword = $this->request->getVar('newpassword');
            if (strlen($newpassword)< 6) {
                $this->session->set('greska', "Greska! Lozinka mora da ima bar 6 karaktera");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            $secondtimepassword = $this->request->getVar('repeteadpassword');
            if ($newpassword != $secondtimepassword) {
                $this->session->set('greska', "Greska! Lozinke nisu iste");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            $korisnikModel = new KorisnikModel();
            
            $korisnikModel->update($korisnik->idKor, ['lozinka' => $newpassword]);
            
            $this->session->set('greska', null);
            $this->session->set('poruka' , 'Uspesno ste promenili lozinku');
            return redirect()->to(site_url("Programer/myProfile"));
    }
    
    public function changeEmail() {
            $username = $this->session->get('username');
            
            $model = new ProgramerModel();
            $korisnici = $model->getProgramersByUsername($username);
            if (count($korisnici) != 1) {
                $this->session->set('greska', "Greska! Korisnik ne postiji");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            $korisnik = $korisnici[0];
            $email = $this->request->getVar('newemail');
            
            $adresa = explode("@", $email);
            
            if (count($adresa) != 2 || $adresa[0] == '' || $adresa[1] == '') {
                $this->session->set('greska', "Greska! Email nije u dobro formatu");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            
            $korisnikModel = new KorisnikModel();
            
            $korisnikModel->update($korisnik->idKor, ['email' => $email]);
            
            $this->session->set('greska', null);
            $this->session->set('poruka' , 'Uspesno ste promenili email');
            return redirect()->to(site_url("Programer/myProfile"));
    }
    
    public function changeNumber() {
            $username = $this->session->get('username');
            
            $model = new ProgramerModel();
            $korisnici = $model->getProgramersByUsername($username);
            if (count($korisnici) != 1) {
                $this->session->set('greska', "Greska! Korisnik ne postiji");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            $korisnik = $korisnici[0];
            $telefon = $this->request->getVar('newphone');
            
            $telefon = implode('', explode (' ', $telefon));
            $brojcifara = strlen($telefon);
            if (  !(  ($telefon[0] == '+' && ($brojcifara == 12 || $brojcifara == 13) && is_numeric(substr($telefon, 1))) || 
                     (($brojcifara == 9 || $brojcifara == 10) && is_numeric($telefon))
                    
                )) {
                $this->session->set('greska', "Greska! Broj telefona nije u ispravnom formatu");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("Programer/myProfile"));
            }
            
            if ($telefon[0] != '+') {
                $telefon = "+381".substr($telefon, 1);
            }
            
            
            $korisnikModel = new KorisnikModel();
            
            $korisnikModel->update($korisnik->idKor, ['broj_telefona' => $telefon]);
            
            $this->session->set('greska', null);
            $this->session->set('poruka' , 'Uspesno ste promenili broj telefona');
            return redirect()->to(site_url("Programer/myProfile"));
    } */
    
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
