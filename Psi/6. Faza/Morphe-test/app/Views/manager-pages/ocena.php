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
   <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/style_1.css"?>" type="text/css">
 
  </head>
  <body>
       <div class="container-fluid">
          <div class="row" id="header" style="padding-top: 1%;">
            <div class="col-1" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/logo.png"?>" style="height: 90px;"> 
            </div>
            
          <!--  <div class="col-1 offset-4" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/mailbox.png"?>" style="height: 60px;"> 
            </div> -->

            <div class="col-1 offset-8 offset-md-9" style="text-align: center;">
                <a href="<?php echo site_url('Menadzer/myProfile/Menadzer')?>"><img src="
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
                        <a class="dropdown-item" href="<?php echo site_url('Menadzer/index')?>">Pocetna</a>
                        <a class="dropdown-item" href="<?php echo site_url('Menadzer/project')?>">Projekat</a>
                        <a class="dropdown-item" href="<?php echo site_url('Menadzer/chat')?>">Razgovori</a>
                        <a class="dropdown-item" href="<?php echo site_url('Menadzer/logout')?>">Izloguj se</a>
                    </div>
                </div>
            </div>

        </div>
       </div>

       <div class="container2">
      
      <h2 style="text-align: center;">Statistika</h2>
      <form method="POST" action="<?php echo site_url('Menadzer/OceniProgramere')?>">
        <div class="container3" style='height:100%'>
          <p>??estitamo na zavr??enom projektu kori????enjem na??e aplikacije! Zna??ilo bi nam kada biste mogli da nam opi??ete Va??e iskustvo.
            Tako??e, mo??ete oceniti programere sa kojim ste sara??ivali na projektu.
          </p>
          <textarea placeholder="Va??e iskustvo na projektu i predlozi za pobolj??anje aplikacije.">
          </textarea>
          <br/><br/>
           <?php 
                for($i=0;$i<count($programeri);$i++){               //   foreach ($programeri as $programer){{$programer->korisnicko_ime}
           echo "<div class='forma'>
            <label>{$programeri[$i]->korisnicko_ime}&nbsp;</label>
            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='radio' name='inlineRadioOptions{$i}' id='inlineRadio1' value='1'>
              <label class='form-check-label' for='inlineRadio1'>1</label>
            </div>
             <div class='form-check form-check-inline'>
              <input class='form-check-input' type='radio' name='inlineRadioOptions{$i}' id='inlineRadio2' value='2'>
              <label class='form-check-label' for='inlineRadio2'>2</label>
            </div>
             <div class='form-check form-check-inline'>
              <input class='form-check-input' type='radio' name='inlineRadioOptions{$i}' id='inlineRadio3' value='3'>
              <label class='form-check-label' for='inlineRadio3'>3</label>
            </div>
             <div class='form-check form-check-inline'>
              <input class='form-check-input' type='radio' name='inlineRadioOptions{$i}' id='inlineRadio4' value='4'>
              <label class='form-check-label' for='inlineRadio4'>4</label>
            </div>
            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='radio' name='inlineRadioOptions{$i}' id='inlineRadio5' value='5'>
              <label class='form-check-label' for='inlineRadio5'>5</label>
            </div>
          </div> 
                             
            
          
       
       
           ";} ?>
                   </div>
         
             <div class='dugmad'>
        
            
                  <a href='<?php echo site_url('Menadzer/index')?>'><input type='button' class='button' id='preskoci' class='btn btn-light' name='Preskoci' value='Preskoci'></a>
                  <input type='submit' class='button' id='posalji' class='btn btn-light' name='Posalji' value='Posalji'>
        
             </div>
 
      </form>
        </div>
      </div>
      
  
      </body>
      </html>