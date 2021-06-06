<!--Julia Milic-->

<html>
 
<head>
     <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Morphe</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/chat.css"?>" type="text/css">
<link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/style.css"?>" type="text/css">
<script src="<?php echo baseUrlWithoutPublic."js/chat.js"?>"></script>
</head>
<body onload="onLoad()">
     <div class="container-fluid">
        <div class="row" id="header" style="padding-top: 1%;">
            <div class="col-1" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/logo.png"?>" style="height: 90px;"> 
            </div>
            

            <div class="col-1 offset-8 offset-md-9" style="text-align: center;">
                <a href="<?php echo site_url('Klijent/myProfile/Klijent')?>"><img src="
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
                        <a class="dropdown-item" href="<?php echo site_url('Klijent/index')?>">Pocetna</a>
                        <a class="dropdown-item" href="<?php echo site_url('Klijent/project')?>">Projekat</a>
                        <a class="dropdown-item" href="<?php echo site_url('Klijent/chat')?>">Razgovori</a>
                        <a class="dropdown-item" href="<?php echo site_url('Klijent/logout')?>">Izloguj se</a>
                    </div>
                </div>
            </div>

        </div>
     </div>
    
<div class="container1">
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Poruke</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                  <input type="text" class="search-bar" id="search-bar" placeholder="Pretraga">
                 </div>
            </div>
          </div>
          <div class="inbox_chat">
            <div class="chat_list active_chat">
                <input type="hidden" id="hidden1" value="<?php 
                    echo '5';
                ?>"> 
              <?php
             $klik;
              for ($i = 0; $i < count($menadzeri); ++$i){
                  if($poruke[$i]!=null)
                  echo ' <a href='.site_url("Klijent/chat/").$menadzeri[$i]->korisnicko_ime.'><div class="chat_list">
                            <div class="chat_people">
                                <div class="chat_ib">
                                    <h5>'.$menadzeri[$i]->korisnicko_ime.'<span class="chat_date">'.$poruke[$i][count($poruke[$i])-1]->datum_vreme_slanja.'</span></h5>
                                    <p>'.$poruke[$i][count($poruke[$i])-1]->tekst.'</p>
                </div>
              </div>
            </div></a>';
                  else  echo ' <a href='.site_url("Klijent/chat/").$menadzeri[$i]->korisnicko_ime.'><div class="chat_list">
                            <div class="chat_people">
                                <div class="chat_ib">
                                    <h5>'.$menadzeri[$i]->korisnicko_ime.'<span class="chat_date"></span></h5>
                                    <p></p>
                </div>
              </div>
            </div></a>';
              }
                ?>
            </div>
              
             
              
     
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">
              <?php 
               echo '<h1>'.$tmpmen.'</h1>';
               for ($i = 0; $i < count($cet); ++$i){
                   if($cet[$i]->poslata_od=="Menadzera")
              echo '<div class="incoming_msg">
              <div class="received_msg">
                <div class="received_withd_msg">
                
                  <p>'.$cet[$i]->tekst.'</p>
                  <span class="time_date">'.$cet[$i]->datum_vreme_slanja.'</span></div>
              </div>
            </div>';
                   else{
                       echo' <div class="outgoing_msg">
              <div class="sent_msg">
                <p>'.$cet[$i]->tekst.'</p>
                <span class="time_date">'.$cet[$i]->datum_vreme_slanja.'</span> </div>
            </div>';
                   }
               }
              ?>
            
           
          </div>
             <form method="post" action="<?php 
             
             echo site_url("Klijent/posalji/{$tmpmen}");
             ?>" name="chatform">
          <div class="type_msg" style="border: solid 2px gray">
            <div class="input_msg_write" style="vertical-align: middle;">
              <input type="text" name="porukica" id="porukica">
              <button style="margin-right: 2%" class="msg_send_btn" id="msg_send_btn" type="submit" value="posalji"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
             </form>
        </div>
      </div>
      
      
    </div></div>
    </body>
    </html>