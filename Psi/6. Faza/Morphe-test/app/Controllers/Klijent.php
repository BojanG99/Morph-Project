<?php

namespace App\Controllers;

use App\Models\MenadzerModel;
use App\Models\KlijentModel;
use App\Models\ProjekatModel;
use App\Models\KlijentProjekatModel;
use App\Models\PorukaModel;
class Klijent extends UserUnspecificControler{

    public function index($menadzeri = null) {
        return view('client-pages/home' , ['menadzeri' => $menadzeri]);
    }
    /**
     * Bojan Galic, Nenad Markovic
     * Ako klijent ceka da mu se projekat zavrsi, prikazuje se stranica sa informacijama o trenutnom projektu.
     * Ako je projekat zavrsen, iskace mu stranica za ocjenjivanje menadzera.
     * Ako klijent ne ceka na neki projekat stranica ispisuje da nema aktivan projekat
     * @return stranica projekta|stranica ocjenjivanja|stranica da nema aktivan projekat
     */
    public function project() {
        
        $uname=$this->session->get('username');
        $kormodel=new \App\Models\KorisnikModel();
        $korisnik=$kormodel->getUsersByUsername($uname);
        
        $klijentPro=new KlijentProjekatModel();
        $projekat=$klijentPro->getFinishedProject($korisnik[0]->idKor);
        
        //ako je projekat zavrsen a nije ocjenjen
        if($projekat!=NULL && $projekat[0]!=NULL ){
            
            
            return $this->ocenaPrikazi();
        }
      
         $projekat1=$klijentPro->getRunningProject($korisnik[0]->idKor);
          
         
             if($projekat1!=NULL && $projekat1[0]!=NULL ){
            
            
            
          $model = new ProjekatModel();
          //$projekat=$model->getProjectForClient($korisnik[0]->idKor);
          $projekat=$model->getActiveProjectForClient($korisnik[0]->idKor);

          $zadaci=$model->getAllTasksForPoject($projekat[0]->idProjekta);
          $i=0;
          $j=0;
          $k=0;
          $ukupno=count($zadaci);
    for($x=0;$x<$ukupno;$x++){
        if($zadaci[$x]->faza=="Implementacije"){
            
            $i++;
        }
        else if($zadaci[$x]->faza=="Testiranja"){
            $j++;
        }
        else{
            $k++;
        }
    }

        if($ukupno == 0)
            $procenat = 0;
        else
        $procenat=($k)*100/$ukupno;   
        
        
        $brojProgramera=count((new ProjekatModel())->getProgramersForProject($projekat[0]->idProjekta));
        return view("client-pages/projekat",[
            'brZad'=>$ukupno,
            'uImplementaciji'=>$i,
            'testiraSe'=>$j,
            'implementirano'=>$k,
            'procenat'=>$procenat,
            'numProgramera'=>$brojProgramera,
            
        ]);
             }
             
             
             return "Nema aktivnog projekta";
    }
    
    
   /*
    Julia Milic
    * ovo je funckija za cet koju poziva client-pages/chat.php
    * dohvata sve menazdere i ispisuje njihove poslednje poruke sa klijentom
    * dohvata sav cet sa kliknnutim menadzerom
    * omogucava pretragu menadzera
    *     */
    
   public function chat($userID=null,$parcial=null) {
        $modelK = new KlijentModel();
        $klijent = $modelK->getClientsByUsername($this->session->get('username'))[0];
        $projekat=$modelK->getProject($klijent->idKor);
       
        $modelM = new MenadzerModel();
        $menadzeri = $modelM->getManagersByPartialUsername($parcial);
        
         $dopisivanje=new PorukaModel();
         $poruke=array();
       
         $i=0;
        foreach($menadzeri as $m){
            $vel=count($dopisivanje->pretragaPoruka($m->idKor,$klijent->idKor));
            if($dopisivanje->pretragaPoruka($m->idKor,$klijent->idKor)==null) $poruke[$i]=null;
            else $poruke[$i]=$dopisivanje->pretragaPoruka($m->idKor,$klijent->idKor);
            $i++;
           
        }
         $count=count($menadzeri);
        for ($k = 0; $k < $count; $k++) {
            if($poruke[$k]==null && ($count-1)!=$k){
                 $temp = $poruke[$k];
                $poruke[$k] = $poruke[$count-1];
                $poruke[$count-1] = $temp;
                 $temp2 = $menadzeri[$k];
                $menadzeri[$k] = $menadzeri[$count-1];
                $menadzeri[$count-1] = $temp2;
            }
        }
          
        for ($k = 0; $k < $count; $k++) {
             if($poruke[$k]==null) continue;
         for ($j = $k + 1; $j < $count; $j++) {
            if($poruke[$j]==null){
               continue;
            }
            if ($poruke[$k][count($poruke[$k])-1]->datum_vreme_slanja < $poruke[$j][count($poruke[$j])-1]->datum_vreme_slanja) {
                $temp = $poruke[$k];
                $poruke[$k] = $poruke[$j];
                $poruke[$j] = $temp;
                $temp2 = $menadzeri[$k];
                $menadzeri[$k] = $menadzeri[$j];
                $menadzeri[$j] = $temp2;
            }
         }
        }
        
         $modelM2 = new MenadzerModel();
         $cet=array();
        if($userID!=null){//dohv sve poruke sa tim menazderom
            $men = $modelM2->getManagersByUsername($userID);
            if($men!=null)
                $cet = $dopisivanje->pretragaPoruka($men[0]->idKor, $klijent->idKor);
         
        }
        
        
   
        
        return view('client-pages/chat', [
            'klijent' => $klijent,
            'menadzeri'=>$menadzeri,
            'projekat'=>$projekat,
            'poruke'=>$poruke,
            'cet'=>$cet,
            'tmpmen'=>$userID,
            'myProfile' => true
       
        ]);
        
     
    }
   
    
     /*
    Julia Milic
    * ovo je funckija za slanje poruka koju poziva client-pages/chat.php
    * omogucava slanje poruka i update baze
    *     */
    
    public function posalji($idMen){
        $model = new KlijentModel();
        $klijent = $model->getClientsByUsername($this->session->get('username'))[0];
        $menModel=new MenadzerModel();
        $usnameMen=$idMen;
        $idMen=$menModel->getManagersByUsername($idMen)[0]->idKor;
       
        $caskanjeModel=new \App\Models\CaskanjeModel();
        
        if($caskanjeModel->checkIfExists($klijent->idKor, $idMen)==false){
            $caskanje=[
                'idKli'=>$klijent->idKor,
                'idMen'=>$idMen
            ];
           // return $klijent->idKor.$idMen;
            $caskanjeModel->insert($caskanje);
        }
     
         $txt = $_POST["porukica"];
       
            if ($txt==null || $txt==""){
                $greska = "Greska! Prazna poruka.";
                return $this->chat($greska);
            }
           $date = new \DateTime(); 
        $string = $date->format('Y-m-d H:i:s');
      //  return 'sda'.strval($txt);
             $mess = [
              'idKli'=>$klijent->idKor,
              'idMen'=>$idMen,
              'tekst'=>$txt,
              'status_poruke'=>'Poslata',
               "poslata_od"=>"Klijenta",
              
              'datum_vreme_slanja'=>$string
                
            ];
            $porukaModel=new PorukaModel();
            $porukaModel->insert($mess);
         return redirect()->to(site_url('Klijent/chat/'.$usnameMen));
      
    } 
    
    /**
     * Nenad Markovic
     * Funkcija otvara i ulazi u myProfile korisnika
     * @return stranica profila aktivnog korisnika
     */
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
    
    /**
     * Bojan Galic, Vlade Vulovic
     * Funkcija trazi i prikazuje sve menadzere
     * @return stranica sa ocenama
     */
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

    /**
     * Bojan Galic
     * @return prikazuje stranicu sa ocenama
     */
     public function ocenaPrikazi(){
        return view("client-pages/ocena");
    }
    
     /**
     * Bojan Galic
     * Davanje ocene menadzeru
     */
    public function oceniMenadzera(){
        $klijentProjekatModel=new KlijentProjekatModel();
        $klijentModel=new KlijentModel();
        $user=$klijentModel->getClientsByUsername($this->session->get('username'))[0];
        
        $tekst = $this->request->getVar('tekstubaci');
        $tip = $this->request->getVar('type'); 
     
        //$klijentModel1 = new KlijentModel();
        $projekat=$klijentProjekatModel->getFinishedProject($user->idKor);
        if($projekat==null && $projekat[0]->status!='Zavrseno'){
            return "Greska ne postoji projekat";
        }
        $menadzerModel=new MenadzerModel();
        $menadzer=$menadzerModel->getManagerForProject($projekat[0]->idProjekta)[0];
        
        $stariProsek=$menadzer->prosecna_ocena;
        $brojOcena=$menadzer->broj_glasova;
        $noviProsek=(($stariProsek)*$brojOcena+$tip)/($brojOcena+1);
        $noviBrojOcena=$brojOcena+1;
        $projekatModel=new ProjekatModel();
         $projekatModel->updateCliProject($user->idKor, $projekat[0]->idProjekta, "Ocenjen");
        $men=[
             'prosecna_ocena'=> $noviProsek,
            'broj_glasova'=> $noviBrojOcena
           
        ];
        
        $menadzerModel->update($menadzer->idMen,$men);
        
      /*       return view('client-pages/ocena', [
            'klijent' => $user,
            'menadzer'=>$menadzer,
             'projekat'=>$projekat,
            'myProfile' => true
           // 'greska' => $greska,
           // 'poruka' => $poruka
        ]);*/
        return $this->index();
        }
    
    
}
