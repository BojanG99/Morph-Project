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
    
    
/**
 * Bojan Galic
 * 
 * Ispisuje stranicu sa zadacima
 * 
 * @param type $greske
 * @return type
 * 
 * 
 */
    public function project($greske=null) {
          $kormodel=new ProgramerModel();
          $uname=$this->session->get('username');
          
          $korisnik=$kormodel->getProgramersByUsername($uname);
          $model = new ProjekatModel();
          $projekat=$model->dohvatiProjekat($korisnik[0]->idKor);
          if($projekat==NULL){
              return $this->index();
          }
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
   // mkdir("/tmp/testing", 0777);
    $pn=$i*100/$ukupno;
    $pp=$j*100/$ukupno;
    $pi=$k*100/$ukupno;
        return view("programmer-pages/projekat.php",[
            'greska'=>$greske,
            'procenatN' => $pn,
            'procenatP' => $pp,
            'procenatI' => $pi,
            'rezultat'=> $zadaci,
            'idProg'=> $korisnik[0]->idKor
         ]);
    }
    
    
    /**
     * 
     * @param type $idZad
     * Id zadatka koji se upload-uje 
     * @param type $greske
     * @return type
     * Vraca stranicu za uplodovanje
     * 
     */
    public function upload($idZad,$greske=null){
       // $greske=$this->session->get('username');
        return view("programmer-pages/upload.php",[
            'idZad'=>$idZad,
            'greska'=>$greske
        ]);
    }
    /**
     * 
     * @param type $idZad
     * @return type
     * Vraca stranicu za upload-ovanje sa ispisom greske, ukoliko je doslo do iste|
     * Vraca se na stranicu projekta
     * 
     */
    public function staviFajlNaServer($idZad){
        
    if(isset($_POST['save'])){
        if(!isset($_FILES['file'])||$_FILES['file']==" " ){
             $greska="Niste postavili fajl";
         return $this->upload($greska);
        }
  
   
    
     $model=new ZadatakModel();
           $zad=$model->getTaskById($idZad);
           if(count($zad)!=1)return $this->project();

    
    //mozda provjera za ekstenziju
    //$extension=pathinfo($filename,PATHINFO_EXTENSIPNS);
    $username=$this->session->get('username');
    $progmodel=new ProgramerModel();
    
    $user=$progmodel->getProgramersByUsername($username);
    $taskmodel=new ZadatakModel();
    $zadaci=$taskmodel->getAllTasksForProgramer($username);
    if($zadaci==NULL){
        header("Location: ". site_url('Programer/project'));
     exit();
    }
    
    for($i =0;$i<count($zadaci);$i++){
        if($zadaci[$i]->idZad==$idZad)break;
        if($i==(count($zadaci)-1)){
             header("Location: ". site_url('Programer/project'));
     exit();
                }
    }
    
    move_uploaded_file($_FILES['file']['tmp_name'], $zad[0]->ime);
    header("Location: ". site_url('Programer/project'));
     exit();
    }
    
    
    header(site_url('Programer/projectdsa')); /* Redirect browser */

/* Make sure that code below does not get executed when we redirect. */
exit;
    
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
    
    public function azurirajZadatk(){
          $implementacija = $this->request->getVar('implementacija');
          $testiranje=$this->request->getVar('testiranje');
          $gotovo= $this->request->getVar('gotovo');
          
          //azuriranje baze
          return $this->project();
    }
    /**
     * Ukoliko je programer kojem pripada zadatak uplodovao isti, ostali programeri i menadzer mogu da skinu taj zadatak
     * @param type $idZad
     * id zadatka kojeg skidamo
     * @return type
     * stranicu sa zadacima
     */
    public function download($idZad){
        
        $model=new ZadatakModel();
        $zad=$model->getTaskById($idZad);
        if(count($zad)!=1)return $this->project();
        $file = $zad[0]->ime; 

header("Content-Description: File Transfer"); 
header("Content-Type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 

readfile ($file);
return;
    }
    
    /**
     * Bojan Galic
     * 
     * Azurira zadatak za ulogovanog programera ukoliko mu taj zadatak pripada
     * @param type $idTask
     * id zadatka koji se azurira
     * @param type $faza
     * u koju fazu prelazi zadatak
     * @return type
     * vraca se na stranicu sa zadacima
     */
    public function updateTasks($idTask,$faza){
        $zadatakModel=new ZadatakModel();
        
         $username=$this->session->get('username');
        $progmodel=new ProgramerModel();
    
    $user=$progmodel->getProgramersByUsername($username);
    $taskmodel=new ZadatakModel();
    $zadaci=$taskmodel->getAllTasksForProgramer($username);
    if($zadaci==NULL){
        header("Location: ". site_url('Programer/project'));
        exit();
    }
        for($i=0;$i<count($zadaci);$i++)
        {
            if($zadaci[$i]->idZad==$idTask)break;
            if($i==(count($zadaci)-1)){
              header("Location: ". site_url('Programer/project'));
              exit();
            }
        }
        if($faza==1){
            $faza="Implementacije";
        }
         
        else if($faza==2){
            $faza="Testiranja";
        }
         
        else if($faza==3){
            $faza="Gotovo";
        }
        else{return $this->project();}
        
        $zadatak=[
           
            'faza'=>$faza
        ];
        $zadatakModel->update($idTask,$zadatak);
         header("Location: ". site_url('Programer/project'));
     exit();
      //  exit();
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
