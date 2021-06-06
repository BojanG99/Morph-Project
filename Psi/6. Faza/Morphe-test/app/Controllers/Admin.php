<?php

namespace App\Controllers;

use App\Models\KorisnikNaCekanjuModel;
use App\Models\KlijentModel;
use App\Models\ProgramerModel;
use App\Models\MenadzerModel;
use App\Models\KorisnikModel;

/**
 * Kontroler za admina
 * 
 * @version 1.0
 * @author Vlade Vulovic <vv180421>
 */
class Admin extends UserUnspecificControler{

    /**
    * Prikazuje pocetnu stranicu
    * @return html-page
    */
    public function index() {
        $korisnkiNaCekanjuModel = new KorisnikNaCekanjuModel();
        $korisniciNaCekanju = $korisnkiNaCekanjuModel->getAllUsersOnHold();
        
        $programerModel = new ProgramerModel();
        $programeri = $programerModel->getAllProgramers();
        
        $menadzerModel = new MenadzerModel();
        $menadzeri = $menadzerModel->getAllManagers();
        
        $klijentModel = new KlijentModel();
        $klijenti = $klijentModel->getAllClients();
        
        
        return view('admin-pages/home', [
            'korisniciNaCekanju' => $korisniciNaCekanju,
            'programeri' => $programeri,
            'menadzeri' => $menadzeri,
            'klijenti' => $klijenti
        ]);
    }
    
    /**
    *  Poziva se prilikom prihvatanja zahteva korisnika
     * @param string $username Korisnicko ime korisnika kome je odobrena registracija
    * @return html-page
    */
    public function acceptUser($username) {
        $korisnkiNaCekanjuModel = new KorisnikNaCekanjuModel();
        $korisnici = $korisnkiNaCekanjuModel->getUsersOnHoldByUsername($username);
        if (count($korisnici) != 1) {
            return redirect()->to(site_url('Home/index'));
        }
        $korisnik = $korisnici[0];
        $korisnkiNaCekanjuModel->delete($korisnik->idKor);
        
        if ($korisnik->tip == "Programer") {
            $model = new ProgramerModel();
            $programer= [
                'idKor' => $korisnik->idKor,
                'prosecna_ocena' => 0.0,
                'broj_glasova' => 0,
                'status_programera' => 'Neangazovan'
            ];
            $model->insert($programer);
        }
        else if ($korisnik->tip == "Menadzer") {
            $model = new MenadzerModel();
            $menadzer = [
                'idKor' => $korisnik->idKor,
                'prosecna_ocena' => 0.0,
                'broj_glasova' => 0,
                'status_menadzera' => 'Neangazovan'
            ];
            $model->insert($menadzer);
        }
        else if ($korisnik->tip == "Klijent") {
            $model = new KlijentModel();
            $klijent = [
                'idKor' => $korisnik->idKor,
            ];
            $model->insert($klijent);
        }
        
        return redirect()->to(site_url('Admin/index'));
    }
    
    /**
    *  Poziva se prilikom odbijanja zahteva korisnika
     * @param string $username Korisnicko ime korisnika kome je odbijena registracija
    * @return html-page
    */
    public function declineUser($username) {
        $korisnkiNaCekanjuModel = new KorisnikNaCekanjuModel();
        $korisnici = $korisnkiNaCekanjuModel->getUsersOnHoldByUsername($username);
        if (count($korisnici) != 1) {
            return redirect()->to(site_url('Admin/index'));
        }
        $korisnik = $korisnici[0];
        $korisnkiNaCekanjuModel->delete($korisnik->idKor);
        
        $korisniciModel = new KorisnikModel();
        $korisniciModel->delete($korisnik->idKor);
        
        return redirect()->to(site_url('Admin/index'));
    }
    
    /**
    *  Poziva se prilikom brisanja korisnika iz baze
     * @param string $username Korisnicko ime korisnika koji se brise
    * @return html-page
    */
    public function deleteUser($username) {
        
        $deleted = -1;
        
        $programerModel = new ProgramerModel();
        $programeri = $programerModel->getProgramersByUsername($username);
        if (count($programeri) == 1) {
            $programerModel->delete ($programeri[0]->idKor);
            $deleted = $programeri[0]->idKor;
        }
        
        
        $menadzerModel = new MenadzerModel();
        $menadzeri = $menadzerModel->getManagersByUsername($username);
        if (count($menadzeri) == 1) {
            $menadzerModel->delete ($menadzeri[0]->idKor);
            $deleted = $menadzeri[0]->idKor;
        }
        
        $klijentModel = new KlijentModel();
        $klijenti = $klijentModel->getClientsByUsername($username);
        if (count($klijenti) == 1) {
            $klijentModel->delete ($klijenti[0]->idKor);
            $deleted = $klijenti[0]->idKor;
        }
        
        if ($deleted != -1) {
            $korisnikModel = new KorisnikModel();
            $korisnikModel->delete($deleted);
        }
        
        return redirect()->to(site_url('Admin/index'));
        
    }
       
}
