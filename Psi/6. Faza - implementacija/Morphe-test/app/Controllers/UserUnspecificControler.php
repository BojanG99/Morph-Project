<?php

namespace App\Controllers;

class UserUnspecificControler extends BaseController{
        
        public function myProfile() {
            return "MojProfil.php";
        }
        
        public function profile($username) {
            
        }
        
        public function logout() {
            $this->session->destroy();
            return redirect()->to(site_url('Home/index'));
        }
       
}
