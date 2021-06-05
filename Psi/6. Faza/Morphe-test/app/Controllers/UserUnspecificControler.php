<?php

namespace App\Controllers;

use App\Models\ProgramerModel;
use App\Models\KlijentModel;
use App\Models\MenadzerModel;
use App\Models\AdminModel;
use App\Models\KorisnikModel;
use App\Models\VremeNaProjektuModel;

class UserUnspecificControler extends BaseController{
        
        protected function getCurrentUser() {
            $controler = $this->session->get('controller');
            $username = $this->session->get('username');
            if (!strcmp($controler, "Programer")) {
                $model = new ProgramerModel();
                return $model->getProgramersByUsername($username)[0];
            }
            if (!strcmp($controler, "Menadzer")) {
                $model = new MenadzerModel();
                return $model->getManagersByUsername($username)[0];
            }
            if (!strcmp($controler, "Klijent")) {
                $model = new KlijentModel();
                return $model->getClientsByUsername($username)[0];
            }
            return null;
        }
        
        protected function getUserByUsername($username) {
            $model = new ProgramerModel();
            $korisnici = $model->getProgramersByUsername($username);
            if (count($korisnici) == 1) {
                $korisnici[0]->tip = "Programer";
                return $korisnici[0];
            }
            $model = new MenadzerModel();
            $korisnici = $model->getManagersByUsername($username);
            if (count($korisnici) == 1) {
                $korisnici[0]->tip = "Menadzer";
                return $korisnici[0];
            }
            $model = new KlijentModel();
            $korisnici = $model->getClientsByUsername($username);
            if (count($korisnici) == 1) {
                $korisnici[0]->tip = "Klijent";
                return $korisnici[0];
            }
            $model = new AdminModel();
            $korisnici = $model->getAdminsByUsername($username);
            if (count($korisnici) == 1) {
                $korisnici[0]->tip = "Admin";
                return $korisnici[0];
            }
            return null;
        }
        
        public function profile($username) {
            return "profil ".$username;
        }
        
        public function logout() {
            
            $startTime = $this->session->get('startTime');
            if ($startTime != null) {
                (new VremeNaProjektuModel())->addTimeForProgramer($this->session->get('username'), $startTime, date('Y-m-d H:i:s'));
            }
            $this->session->destroy();
            return redirect()->to(site_url('Home/index'));
        }
        
        public function CV($username) {
            $model = new ProgramerModel();
            $korisnici = $model->getProgramersByUsername($username);

            if (count($korisnici) != 1) {
                return "Greska! Pokusali ste otvoriti CV za korisnika koji ne postoji!";
            } 
            
            if ($korisnici[0]->cv_URL == null) {
                return "Korisnik nije postavi CV!";
            }

            $filepath = baseUrlWithoutPublic.$korisnici[0]->cv_URL; 

            $this->response->setStatusCode(200)->setBody(readfile($filepath));
            $this->response->setHeader('Content-type', 'application/pdf');
        
        }
        
        public function uploadPicture() {
        
            if (isset($_FILES['profileFile']['error']) && $_FILES['profileFile']['error'] != 0) {
                $this->session->set('greska', "Greska prilikom slanja! Fajl je verovatno preveliki! Maksimalna velicina fajl 2MB. ");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }

            if (isset($_FILES['profileFile']['type'])) $imageFileType = $_FILES['profileFile']['type'];
            else $imageFileType = "";

            if ($imageFileType != "image/jpg" && $imageFileType != 'image/png' && $imageFileType != 'image/jpeg') {
                $this->session->set('greska', "Greska! Slika mora biti mora biti u jednom od formata: jpg , png , jpeg");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }

            if(isset($_POST["submit"])) { //neka provera za ispravnosti fajlova
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check === false) {
                        $this->session->set('greska', "Greska! Nesto nije u redu sa slikom koju ste poslali");
                        $this->session->set('poruka' , null);
                        return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
                    }
            }

            $username = $this->session->get('username');
            $target_dir = "images/users-profile-images/";
            $target_file = $target_dir. $username . '.' . substr($imageFileType, 6);

            if (file_exists($target_file)) {
                if (!unlink($target_file)) {
                    $this->session->set('greska', "Greska! Doslo je do greske prilikom uplodovanja file");
                    $this->session->set('poruka' , null);
                    return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
                }
            }

            if (move_uploaded_file($_FILES["profileFile"]["tmp_name"], rootDirectory.$target_file)) {
                $model = new KorisnikModel();
                $korisnik = $model->getUsersByUsername($username)[0];
                $model->update($korisnik->idKor ,['slika_URL' => $target_file]);
                $this->session->set('slika_URL', $target_file);
                $this->session->set('greska', null);
                $this->session->set('poruka' , "Uspesno ste uplodovali sliku");
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }

            $this->session->set('greska', "Greska! Doslo je do greske prilikom uplodovanja file");
            $this->session->set('poruka' , null);
            return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
        }
        
        public function changePassword() {
            
            $korisnik = $this->getCurrentUser();
            if ($korisnik == null) {
                $this->session->set('greska', "Greska! Korisnik ne postiji");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            $oldpassword = $this->request->getVar('oldpassword');
            if ($korisnik->lozinka != $oldpassword) {
                $this->session->set('greska', "Greska! Pogresna stara lozinka");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            $newpassword = $this->request->getVar('newpassword');
            if (strlen($newpassword)< 6) {
                $this->session->set('greska', "Greska! Lozinka mora da ima bar 6 karaktera");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            $secondtimepassword = $this->request->getVar('repeteadpassword');
            if ($newpassword != $secondtimepassword) {
                $this->session->set('greska', "Greska! Lozinke nisu iste");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            $korisnikModel = new KorisnikModel();
            
            $korisnikModel->update($korisnik->idKor, ['lozinka' => $newpassword]);
            
            $this->session->set('greska', null);
            $this->session->set('poruka' , 'Uspesno ste promenili lozinku');
            return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
    }
    
    public function changeEmail() {
            
            $korisnik = $this->getCurrentUser();
            if ($korisnik == null) {
                $this->session->set('greska', "Greska! Korisnik ne postiji");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            $email = $this->request->getVar('newemail');
            
            $adresa = explode("@", $email);
            
            if (count($adresa) != 2 || $adresa[0] == '' || $adresa[1] == '') {
                $this->session->set('greska', "Greska! Email nije u dobro formatu");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            
            $korisnikModel = new KorisnikModel();
            
            $korisnikModel->update($korisnik->idKor, ['email' => $email]);
            
            $this->session->set('greska', null);
            $this->session->set('poruka' , 'Uspesno ste promenili email');
            return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
    }
    
    public function changeNumber() {
        
            $korisnik = $this->getCurrentUser();
            if ($korisnik == null) {
                $this->session->set('greska', "Greska! Korisnik ne postiji");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            $telefon = $this->request->getVar('newphone');
            
            $telefon = implode('', explode (' ', $telefon));
            $brojcifara = strlen($telefon);
            if (  !(  ($telefon[0] == '+' && ($brojcifara == 12 || $brojcifara == 13) && is_numeric(substr($telefon, 1))) || 
                     (($brojcifara == 9 || $brojcifara == 10) && is_numeric($telefon))
                    
                )) {
                $this->session->set('greska', "Greska! Broj telefona nije u ispravnom formatu");
                $this->session->set('poruka' , null);
                return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
            }
            
            if ($telefon[0] != '+') {
                $telefon = "+381".substr($telefon, 1);
            }
            
            
            $korisnikModel = new KorisnikModel();
            
            $korisnikModel->update($korisnik->idKor, ['broj_telefona' => $telefon]);
            
            $this->session->set('greska', null);
            $this->session->set('poruka' , 'Uspesno ste promenili broj telefona');
            return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
    }
        
       
}
