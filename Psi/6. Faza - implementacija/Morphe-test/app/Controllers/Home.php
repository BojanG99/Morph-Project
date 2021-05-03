<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\KlijentModel;
use App\Models\MenadzerModel;
use App\Models\ProgramerModel;
use App\Models\KorisnikModel;
use App\Models\KorisnikNaCekanjuModel;

class Home extends BaseController{
    
        private $minPasswordLenght = 6;
    
    
	public function index(){
            return view("home/loginpage");  
	}
        
        public function loginpage($greska = null) {
            return view("home/loginpage", ['greska' => $greska]);
        }
        
        public function registerpage($greska = null , $uspesno = null) {
            return view("home/registerpage", ['greska' => $greska , 'uspesno' => $uspesno]);
        }
        
        public function login() {
            $username = $this->request->getVar('usernameinput');
            $password = $this->request->getVar('passwordinput');
            
            if (strlen($username) == 0 || strlen($password) == 0)  {
                $greska = "Korisnicko ime i lozinka su obavezna polja!";
                return $this->loginpage($greska);
            }
            
            $adminModel = new AdminModel();
            $korisnici = $adminModel->getAdminsByUsername($username);
            if (count($korisnici) == 1 && $korisnici[0]->lozinka == $password) {
                $this->session->set('username', $username);
                $this->session->set('password', $password);
                $this->session->set('slika_URL' , $korisnici[0]->slika_URL);
                $this->session->set('controller', 'Admin');
                return redirect()->to(site_url('Admin'));
            }
            
            $korisnkNaCekanjuModel = new KorisnikNaCekanjuModel();
            $korisniciNaCekanju = $korisnkNaCekanjuModel->getAllUsersOnHold();
            
            foreach ($korisniciNaCekanju as $korisnik) {
                if ($korisnik->korisnicko_ime == $username) {
                    $greska = "Ne mozete se ulogovati. Admin nije obradio vas zahtev!";
                    return $this->loginpage($greska);
                }
            }
           
            
            $klijentModel = new KlijentModel();
            $korisnici = $klijentModel->getClientsByUsername($username);
            if (count($korisnici) == 1 && $korisnici[0]->lozinka == $password) {
                $this->session->set('username', $username);
                $this->session->set('password', $password);
                $this->session->set('slika_URL' , $korisnici[0]->slika_URL);
                $this->session->set('controller', 'Klijent');
                return redirect()->to(site_url('Klijent'));
            }
            
            $menadzerModel = new MenadzerModel();
            $korisnici = $menadzerModel->getManagersByUsername($username);
            if (count($korisnici) == 1 && $korisnici[0]->lozinka == $password) {
                $this->session->set('username', $username);
                $this->session->set('password', $password);
                $this->session->set('slika_URL' , $korisnici[0]->slika_URL);
                $this->session->set('controller', 'Menadzer');
                return redirect()->to(site_url('Menadzer'));
            }
            
            $programerModel = new ProgramerModel();
            $korisnici = $programerModel->getProgramersByUsername($username);
            if (count($korisnici) == 1 && $korisnici[0]->lozinka == $password) {
                $this->session->set('username', $username);
                $this->session->set('password', $password);
                $this->session->set('slika_URL' , $korisnici[0]->slika_URL);
                $this->session->set('controller', 'Programer');
                return redirect()->to(site_url('Programer'));
            }
            
            $greska = "Korisnicko ime ili lozinka su pogresni!";
            return $this->loginpage($greska);
        }
        
        public function register() {
            
            $username = $this->request->getVar('usernameinput');
            $password = $this->request->getVar('passwordinput');
            $password2 = $this->request->getVar('passwordagaininput');
            $email = $this->request->getVar('emailinput');
            $telefon = $this->request->getVar('numberinput');
            $tip = $this->request->getVar('type'); 
            
            
            if (strlen($username) == 0 || strlen($password) == 0 || strlen($password2) == 0 || strlen($email) == 0 || strlen($telefon) == 0)  {
                $greska = "Sva polja su obavezna!";
                return $this->registerpage($greska);
            }
            
            $korisnikModel = new KorisnikModel();
            $korisnici = $korisnikModel->findAll();
            
            $usernameFound = false;
            foreach ($korisnici as $korisnik) {
                if ($korisnik->korisnicko_ime == $username) {
                    $usernameFound = true;
                }
            }
            
            if ($usernameFound) {
                $greska = "Korisnicko ime postoji";
                return $this->registerpage($greska);
            }
            
            //dodati proveru ako hocemo neki format lozinke
            if (strlen($password) < $this->minPasswordLenght) {
                $greska = "Lozinka mora imati bar 6 karaktera!";
                return $this->registerpage($greska);
            }
            
            if ($password != $password2) {
                $greska = "Lozinka i ponovljena lozinka nisu iste!";
                return $this->registerpage($greska);
            }
            
            $adresa = explode("@", $email);
            
            if (count($adresa) != 2 || $adresa[0] == '' || $adresa[1] == '') {
                $greska = "Email nije u dobro formatu!";
                return $this->registerpage($greska);
            }

            $telefon = implode('', explode (' ', $telefon));
            $brojcifara = strlen($telefon);
            if (  !(  ($telefon[0] == '+' && ($brojcifara == 12 || $brojcifara == 13) && is_numeric(substr($telefon, 1))) || 
                     (($brojcifara == 9 || $brojcifara == 10) && is_numeric($telefon))
                    
                )) {
                $greska = "Broj telefona nije u ispravnom formatu";
                return $this->registerpage($greska);
            }
            
            if ($telefon[0] != '+') {
                $telefon = "+381".substr($telefon, 1);
            }
            
            $korisnik = [
                'korisnicko_ime' => $username,
                'lozinka' => $password,
                'email' => $email,
                'broj_telefona' => $telefon,
            ];
                
            $korisnikModel->insert($korisnik);
            
            $modelZaPoslateZahteve = new KorisnikNaCekanjuModel();
            
            $trenutni_korisnik = [
                'idKor' => (int)$korisnikModel->getInsertID(),
                'tip' => $tip
            ]; 
                    
            $modelZaPoslateZahteve->insert($trenutni_korisnik);
            
            $uspesno = 'Uspesno ste se registrovali';
            
            return $this->registerpage(null , $uspesno);
            
        }
}
