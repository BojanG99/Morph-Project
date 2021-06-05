<?php

namespace App\Controllers;

use App\Models\ProgramerModel;
use App\Models\MenadzerModel;
use App\Models\KonkursModel;
use App\Models\PozvanNaKonkursModel;
use App\Models\ProjekatModel;
use App\Models\ZadatakModel;
use App\Models\FajlZaZadatakModel;
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
    
    public function myProfile() {
        
        $model = new MenadzerModel();
        $menadzer = $model->getManagersByUsername($this->session->get('username'))[0];
        
        $modelProjekat = new ProjekatModel();
        
        $brojProjekat = count($modelProjekat->getAllProjectsForManager($menadzer->korisnicko_ime));
        
        $greska = $this->session->get('greska');
        $poruka = $this->session->get('poruka');
        
        $this->session->set('greska', null);
        $this->session->set('poruka', null);
        
        return view('manager-pages/profile', [
            'menadzer' => $menadzer,
            'brojProjekata' => $brojProjekat,
            'myProfile' => true,
            'greska' => $greska, 
            'poruka' => $poruka
        ]);
    }
    
    /**
     * Bojan Galić 0387/2018
     * Prikazuje izgled projekta za menadzera
     * 
     * @return type
     */
    public function project() {
        $model = new ProjekatModel();
        $mmodel=new MenadzerModel();
        $uname=$this->session->get('username');
          
        $korisnik=$mmodel->getManagersByUsername($uname);
        //provjera da li projekat postoji
        
        $projekat=$model->dohvatiAktivanProjekatZaMenadzera($korisnik[0]->idKor);
        
        if($projekat==NULL||$projekat[0]==NULL){
            
        
            return $this->index();
        }
        
        //////////////////
       
      //    $model = new ProjekatModel();
         
       
          $zadaci=$model->getAllTasksForPoject($projekat[0]->idPro);//$projekat[0]->idProjekta);
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
    $pn=$i*100/$ukupno;
    $pp=$j*100/$ukupno;
    $pi=$k*100/$ukupno;
    
        return view("manager-pages/projekat",[  'procenatN' => $pn,
            'procenatP' => $pp,
            'procenatI' => $pi,
            'rezultat'=> $zadaci,
            'idProg'=> $korisnik[0]->idKor]);
    }
    /**
     * Bojan Galic
     * @param type $idZad
     * Skida fajl u kom je smjesten Zadatak sa id-om $idZad
     * @return type
     * 
     * 
     */
        public function download($idZad){
        //dodati provjeru da li je zadatak stvarno u njegovom projektu
        $model=new ZadatakModel();
        $zad=$model->getTaskById($idZad);
        if(count($zad)!=1)return $this->project();
        $file = $zad[0]->ime; 
        
        if(!file_exists($file))return $this->project();

    header("Content-Description: File Transfer"); 
    header("Content-Type: application/octet-stream"); 
    header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 

    readfile ($file);
   
    return $this->project();
    }
    
    /**
     * Bojan Galic
     * @param type $greske
     *
     *   Prikazuje stranicu sa formom za dodavanje novog zadatka.
     * U slucaju da neki unosi u formi ne zadovoljavaju kriterijum parametar $greske ce se ispisati i obavjestiti menadzera o gresci
     * @return stranica sa formom za dodavanje novog zadatka
     */
    public function dodajZadatak($greske=null){
        //dohvatiti sve programere po id-u
        $projekatModel=new ProjekatModel();
        $projekat=$projekatModel->getProjectForManagerUname($this->session->get('username'));
        
        $programeri=$projekatModel->getProgramersForProject($projekat[0]->idProjekta);
        return view("manager-pages/add-task",['greske'=>$greske,'programeri'=>$programeri]);
    }
    
    /**
     * Bojan Galic
     * 
     * Obradjuje unos sa forme za dodavanje novog zadatka i ukoliko je ispravan ubacuje novi zadatak u bazu podataka
     * @return type
     * 
     */
    public function sacuvajZadatak(){
            $username=$this->session->get("username");
            $model=new MenadzerModel();
           $user=$model->getManagersByUsername($username);
            
            $projectModel=$model->getProjectFotManager($username);
            $greska="";
            $file=$this->request->getVar('file');
            $path=$this->request->getVar('path');
            $option=$this->request->getVar('option');
            $tasktext=$this->request->getVar('tasktext');
            
            if($file=="")$greska=$greska."Nije unjet naziv fajla fajla :";
            if($path=="")$greska=$greska."Nije unjeta putanja do fajla :";
            if($option=="")$greska=$greska."Nije unjet programer";
            if($tasktext=="")$greska=$greska."Nije unjet opis zadatka";
            
                    $selected="NIste izabrali"       ;         
    if(!empty($_POST['option'])) {
        $selected = $_POST['option'];
     
    } else {
        $selected= 'Please select the value.';
    }
            
            
            $newTask=[
                'idProjekta'=>$projectModel[0]->idPro,
                'idProgramera'=>$selected,
                'opis'=>$tasktext,
                'faza'=>"Implementacije"
                        
            ];
         
            $modelZad=new ZadatakModel();
            
            $idZad=$modelZad->insert($newTask,true);
            $modelPro=new ProgramerModel();
            $programer=$modelPro->getProgramerById($selected);
               $newTaskPath=[
                'idZad'=> $idZad ,
                'ime'=>"C:/projects/project".$projectModel[0]->idPro."/".$programer[0]->korisnicko_ime."/".$path.$file
            ] ;
               $putanja="C:/projects/project".$projectModel[0]->idPro."/".$programer[0]->korisnicko_ime."/".$path.$file;
               if(!file_exists($putanja))
                    mkdir($putanja,0777,true);
            $modelFajlZad=new FajlZaZadatakModel();
            $modelFajlZad->insert($newTaskPath);
            
 
    
            //exit();
  //  if($projectModel!=null)
    //         return view("manager-pages/add-task",['greske'=>$projectModel[0]->idPro]);
        
    
       return $this->index();
    }
   public function chat($userName=null,$parcial=null) {
        $modelM = new MenadzerModel();
        $menadzer = $modelM->getManagersByUsername($this->session->get('username'))[0];
        $projekat=$modelM->getProjectForManager($menadzer->idKor);
       
        $modelK = new \App\Models\KlijentModel();
        $klijenti = $modelK->getClientsByPartialUsername($parcial);
      
         $dopisivanje=new \App\Models\PorukaModel();
         $poruke=array();
       
         $i=0;
        foreach($klijenti as $k){
            $vel=count($dopisivanje->pretragaPoruka($menadzer->idKor,$k->idKor));
            if($dopisivanje->pretragaPoruka($menadzer->idKor,$k->idKor)==null) $poruke[$i]=null;
            else $poruke[$i]=$dopisivanje->pretragaPoruka($menadzer->idKor,$k->idKor);
            $i++;
           
        }
         $modelK2 = new \App\Models\KlijentModel();
         $cet=array();
        if($userName!=null){//dohv sve poruke sa tim menazderom
            $kli = $modelK2->getClientsByPartialUsername($userName);
            if($kli!=null)
                $cet = $dopisivanje->pretragaPoruka($menadzer->idKor,$kli[0]->idKor);
        }
        
          $count=count($klijenti);
        for ($k = 0; $k < $count; $k++) {
            if($poruke[$k]==null && ($count-1)!=$k){
                 $temp = $poruke[$k];
                $poruke[$k] = $poruke[$count-1];
                $poruke[$count-1] = $temp;
                 $temp2 = $klijenti[$k];
                $klijenti[$k] = $klijenti[$count-1];
                $klijenti[$count-1] = $temp2;
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
                $temp2 = $klijenti[$k];
                $klijenti[$k] = $klijenti[$j];
                $klijenti[$j] = $temp2;
            }
         }
        }
   
        
        return view('manager-pages/chat', [
            'menadzer' => $menadzer,
            'klijenti'=>$klijenti,
            'projekat'=>$projekat,
            'poruke'=>$poruke,
            'cet'=>$cet,
            'tmpkli'=>$userName,
            'myProfile' => true
       
        ]);
        
     
    }
   
    public function posalji($idKli){
        $model = new MenadzerModel();
        $menadzer = $model->getManagersByUsername($this->session->get('username'))[0];
        $kormodel=new \App\Models\KorisnikModel();
        $klijent=$kormodel->getUsersByUsername($idKli)[0];
         $txt = $this->request->getVar('porukica');
            if ($txt==null || $txt==""){
                $greska = "Greska! Prazna poruka.";
                return $this->chat($idKli);
            }
            
             $caskanjeModel=new \App\Models\CaskanjeModel();
        
        if($caskanjeModel->checkIfExists($klijent->idKor, $menadzer->idKor)==false){
            $caskanje=[
                'idKli'=>$klijent->idKor,
                'idMen'=>$menadzer->idKor
            ];
           // return $klijent->idKor.$idMen;
            $caskanjeModel->insert($caskanje);
        }
     
            
            
            
            $date = new \DateTime(); 
        $string = $date->format('Y-m-d H:i:s');
             $mess = [
              'idMen'=>$menadzer->idKor,
              'idKli'=>$klijent->idKor,
              'tekst'=>$txt,
              'status_poruke'=>'Poslata',
              "poslata_od"=>"Menadzera",
              'datum_vreme_slanja'=>$string
            ];
            $porukaModel=new \App\Models\PorukaModel();
            $porukaModel->insert($mess);
            
            return $this->chat($idKli);
    }
    public function okoncajProjekat(){
         $uname=$this->session->get('username');
          $mmodel=new MenadzerModel();
         $korisnik=$mmodel->getManagersByUsername($uname);
         
         $projekatModel=new ProjekatModel();
         
         $projekat=$projekatModel->dohvatiAktivanProjekatZaMenadzera($korisnik[0]->idKor);
         
         if($projekat==NULL){
             
             return "nema projekat";
         }
         $klijent=new \App\Models\KlijentProjekatModel();
         
         $kli=$klijent->getClientForProject($projekat[0]->idProjekta);
         
         $projekatModel->updateCliProject($kli[0]->idKli, $projekat[0]->idPro, "Zavrsen");
         $projekatModel->updateMenProject($korisnik[0]->idKor,$projekat[0]->idProjekta,"Neaktivan");
         
         
       $programeri= $projekatModel->getProgramersForProject($projekat[0]->idPro);
       $programerRad=new \App\Models\ProgramerRadiNaProjektuModel();
        for($i=0;$i<count($programeri);$i++){
            $updejt=['idProjekta'=>$projekat[0]->idPro,
                'idProgramera'=>$programeri[$i]->idProgramera,
            'status'=>'Neaktivan'];
           
         //   return 'idProjekta'.$projekat[0]->idPro.
         //       'idProgramera'.$programeri[$i]->idProgramera.
        //        'status'.'Neaktivan';
            $programerRad->updateProg($programeri[$i]->idProgramera,$projekat[0]->idPro,'Neaktivan');
        }
        
        
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
       

    public function ocenaPrikazi(){
        
        $menadzer=$this->session->get('username');
        $menModel=new MenadzerModel();
        $men=$menModel->getManagersByUsername($menadzer);
        $projekatModel=new ProjekatModel();
        $projekat=$projekatModel->dohvatiAktivanProjekatZaMenadzera($men[0]->idKor)[0];
        // dohvati projekat
        
        
        //dohvati programere za projekat
        $progradinaMod=new \App\Models\ProgramerRadiNaProjektuModel();
        
        $programeri=$progradinaMod->getAllProgramersWorkingOnProject($projekat->idPro);
        return view("manager-pages/ocena",
                [
                    'programeri'=>$programeri
                ]
                );
    }

    
      public function OceniProgramere(){

            
        $menadzer=$this->session->get('username');
        $menModel=new MenadzerModel();
        $men=$menModel->getManagersByUsername($menadzer);
        $projekatModel=new ProjekatModel();
        $projekat=$projekatModel->dohvatiAktivanProjekatZaMenadzera($men[0]->idKor)[0];
        // dohvati projekat
        $promodel=new ProgramerModel();
         $progradinaMod=new \App\Models\ProgramerRadiNaProjektuModel();
        
        $programeri=$progradinaMod->getAllProgramersWorkingOnProject($projekat->idPro);
            
      
        $programerRadi=new \App\Models\ProgramerRadiNaModel();
        $programeri=$projekatModel->getProgramersForProject($projekat->idPro);
        //if($programeri==null) {return "Greska ne postoje programeri";}
      for($i=0;$i<count($programeri);$i++){
          $tip=$this->request->getVar("inlineRadioOptions".$i);
          
          
          //////////////////////////
            
   
        
        $stariProsek=$programeri[$i]->prosecna_ocena;
        $brojOcena=$programeri[$i]->broj_glasova;
        $noviProsek=(($stariProsek)*$brojOcena+intval($tip))/($brojOcena+1);
        $noviBrojOcena=$brojOcena+1;
        
        $pro=[
             'prosecna_ocena'=> $noviProsek,
            'broj_glasova'=> $noviBrojOcena
           
        ];
        
        $promodel->update($programeri[$i]->idKor,$pro);
          
          
          
          
          
          /////////////////////////
          
      }
        
        //dohvati programere za projekat
       $this->okoncajProjekat();
           return redirect()->to(site_url("{$this->session->get('controller')}/myProfile"));
      return "updejt".$projekat->idPro;
        }
    
    
    
}
