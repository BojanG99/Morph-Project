

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morphe</title>
    <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/style.css"?>" type="text/css">
    <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/zadaci.css"?>" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
    <style>
        .borderless td , .borderless th {
            border: none;
        }
    </style>
    
</head>
<body >
    <form action="<?php echo site_url('Programer/azurirajZadatk') ?>" method="POST">
    <div class="container-fluid">
        <div class="row" id="header" style="padding-top: 1%;">
            <div class="col-1" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/logo.png"?>" style="height: 90px;"> 
            </div>
            
          <!--  <div class="col-1 offset-4" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/mailbox.png"?>" style="height: 60px;"> 
            </div> -->

            <div class="col-1 offset-8 offset-md-9" style="text-align: center;">
                <a href="<?php echo site_url('Programer/myProfile')?>"><img src="
                        <?php 
                            if (!empty($_SESSION['slika_URL'])) echo baseUrlWithoutPublic.$_SESSION['slika_URL'];
                                else echo baseUrlWithoutPublic."images/unknownuser.jpg"
                        ?> " 
                    style="height: 55px;">
                    </a>
                
                <p style="text-align:center">
                    <?php
                        echo $_SESSION['username'];
                    ?>
                </p>
            </div>

            <div class="col-1 offset-1 offset-md-0" >
                <div class="dropdown dropleft" >
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                    style="display: inline; vertical-align: middle; padding-right: 50px;" >
                    </button>
    
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo site_url('Programer/index')?>">Pocetna</a>
                        <a class="dropdown-item" href="<?php echo site_url('Programer/project')?>">Projekat</a>
                        <!--    <a class="dropdown-item" href="<?php echo site_url('Programer/chat')?>">Razgovori</a> -->
                        <a class="dropdown-item" href="<?php echo site_url('Programer/logout')?>">Izloguj se</a>
                    </div>
                </div>
            </div>

        </div>
        </div>
    
    <div class="progress" style="height:20px">
        
        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width:
             <?php echo $procenatN ?>%;opacity: 50%"><?php echo $procenatN ?>%</div>
 <div class="progress-bar progress-bar-striped progress-bar-animated" 
      style="width: <?php echo $procenatP ?>%;opacity: 50%"> <?php echo $procenatP ?>% </div>



<div class="progress-bar bg-success progress-bar-striped
progress-bar-animated" style="width:<?php echo $procenatI ?>%;opacity: 50%"><?php echo $procenatI ?>%</div>
    </div>
    
    
    <script>

function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
   
  var id=ev.target.id;
  
  <?php
  
  ?>
  var ime=document.getElementById(id).parentNode.getAttribute('name');
     
  if(ime=="implementacija"){
      window.location.href = "<?php   echo site_url('Programer/updateTasks/')?>"+data+'/1';
  }
  else if(ime=='testiranje'){

        window.location.href = "<?php   echo site_url('Programer/updateTasks/')?>"+data+'/2';
      
  }
  else{
        window.location.href = "<?php   echo site_url('Programer/updateTasks/')?>"+data+'/3';
  }
  document.getElementById(id).parentNode.appendChild(document.getElementById(data));
  
}
</script>


    <div>
        
        <div style="width:33%;height: 100%;float:left;background-color: #ff222250">
         <div clas="container">
                <div class="row" ondrop="drop(event)" name="implementacija" ondragover="allowDrop(event)">
                    <div id="div1" align="center" class="col-12" style="width: 100%;height: 100px">IMPLEMENTACIJA <i class="fa fa-gear" aria-hidden="true"></i></div>
                      <?php 
                    
                    for($i=0;$i<count($rezultat);$i++){
                          $nova= "";
                             $dwnload=site_url('Programer/download/' .$rezultat[$i]->idZad );
                    if($rezultat[$i]->idProgramera==$idProg){
                        $drag='draggable="true" ondragstart="drag(event)"';
                        $lock='fa-unlock';
                         $nova= site_url('Programer/upload/'
                              .$rezultat[$i]->idZad );
                    } else {
                        $drag='';
                        $lock='fa-lock';
                    }
                        if($rezultat[$i]->faza=="Implementacije")
                    echo   '<div class="col-md-6 col-xl-6" id="'.$rezultat[$i]->idZad.'" '.$drag.'>
             
            
                <div class="image-box image-box--shadowed white-bg style-2 mb-4">
                  
                 <div class="container" style="border:1px solid black">
                    <div class="row">
                    <div class="col-12">
                    '.$rezultat[$i]->opis.'
                    </div>
                    <div class="col-12">
                      <ul class="social-links small circle">
                        <li ><a href="'.$nova.'"><i class="fa fa-upload"></i></a></li>
                        <li ><a href="'.$dwnload.'"><i class="fa fa-download"></i></a></li>
                        <li ><a href="#"><i class="fa fa-user"></i></a></li>
                        <li ><a href="#"><i class="fa '.$lock.'"></i></a></li>
                      </ul>
                   </div>
                  </div>
                  </div>
                </div>
            </div>';
                    
                  }
                    ?>
              
                </div>
         </div>
        </div>
        
        
        <div style="width:34%;height: 100%;float:left;background-color: #0000ff50">
            
            <div clas="container">
                <div class="row" ondrop="drop(event)" name="testiranje" ondragover="allowDrop(event)" >
                    <div id="div2" align="center"  style="height: 100px;" class="col-12">TESTIRANJE <i class="fa fa-plug" aria-hidden="true"></i></div>
                    <?php 
                    
                      for($i=0;$i<count($rezultat);$i++){
                          $nova= "";
                             $dwnload=site_url('Programer/download/' .$rezultat[$i]->idZad );
                    if($rezultat[$i]->idProgramera==$idProg){
                        $drag='draggable="true" ondragstart="drag(event)"';
                         $lock='fa-unlock';
                             $nova= site_url('Programer/upload/'
                              .$rezultat[$i]->idZad );
                    } else {
                        $drag='';
                         $lock='fa-lock';
                    }
                        if($rezultat[$i]->faza=="Testiranja")
                    echo   '<div class="col-md-6 col-xl-6" id="'.$rezultat[$i]->idZad.'" '.$drag.'>
            
                <div class="image-box image-box--shadowed white-bg style-2 mb-4">
                  
                 <div class="container" style="border:1px solid black">
                    <div class="row">
                    <div class="col-12">
                    '.$rezultat[$i]->opis.'
                    </div>
                    <div class="col-12">
                      <ul class="social-links small circle">
                        <li class="facebook"><a href="'.$nova.'"><i class="fa fa-upload"></i></a></li>
                        <li class="twitter"><a href="'.$dwnload.'"><i class="fa fa-download"></i></a></li>
                        <li class="googleplus"><a href="#"><i class="fa fa-user"></i></a></li>
                        <li class="instagram"><a href="#"><i class="fa '.$lock.'"></i></a></li>
                      </ul>
                   </div>
                  </div>
                  </div>
                </div>
            </div>';
                    
                  }
                    ?>
              
             
             
              
                </div>
            </div>
        </div>
       
        
        
        <div    style="width:33%;height: 100%;float:left;background-color: #00ff0050">
            
           <div clas="container">
                <div class="row" ondrop="drop(event)" name="gotovo" ondragover="allowDrop(event)" >
                    <div id="div3" align="center" n class="col-12"  style="height: 100px;">GOTOVO <i class="fa fa-check" aria-hidden="true"></i></div>
              
                  <?php 
                 
                     for($i=0;$i<count($rezultat);$i++){
                          $nova= "";
                          $dwnload=site_url('Programer/download/' .$rezultat[$i]->idZad );
                    if($rezultat[$i]->idProgramera==$idProg){
                        $drag='draggable="true" ondragstart="drag(event)"';
                         $lock='fa-unlock';
                          $nova= site_url('Programer/upload/'
                              .$rezultat[$i]->idZad );
                    } else {
                        $drag='';
                         $lock='fa-lock';
                    }
                        if($rezultat[$i]->faza=="Gotovo")
                    echo   '<div class="col-md-6 col-xl-6" id="'.$rezultat[$i]->idZad.'" '.$drag.'>
            
                <div class="image-box image-box--shadowed white-bg style-2 mb-4">
                  
                 <div class="container" style="border:1px solid black">
                    <div class="row">
                    <div class="col-12">
                    '.$rezultat[$i]->opis.'
                    </div>
                    <div class="col-12">
                      <ul class="social-links small circle">
                        <li class="facebook"><a href="'.$nova.'"><i class="fa fa-upload"></i></a></li>
                        <li class="twitter"><a href="'.$dwnload.'"><i class="fa fa-download"></i></a></li>
                        <li class="googleplus"><a href="'.site_url('Programer/logout').'"><i class="fa fa-user"></i></a></li>
                        <li class="instagram"><a href="#"><i class="fa '.$lock.'"></i></a></li>
                      </ul>
                   </div>
                  </div>
                  </div>
                </div>
            </div>';
                    
                  }
                    ?>
              
                </div>
         </div>
            
        </div>
        
    </div>
<!--
<div style="border: 5 solid red">fasf</div>
   

<div class="card" style="width: 18rem;">
 
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
    -->
    </form>
    <?php echo $greska?>
</body>

</html>
<?php



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

