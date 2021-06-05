
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morphe</title>
    <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/style.css"?>" type="text/css">
    
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
<body style="background-color: blanchedalmond;">
    
    <div class="container-fluid">
        <div class="row" id="header" style="padding-top: 1%;">
            <div class="col-1" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/logo.png"?>" style="height: 90px;"> 
            </div>
            
          <!--  <div class="col-1 offset-4" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/mailbox.png"?>" style="height: 60px;"> 
            </div> -->

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

        <br>
        
        <h1 style="text-align: center">Moj profil</h1>
        
        <?php
            if (!empty($greska)) {
                echo "<h3 style='text-align: center; color:red'>{$greska}</h1>";
            }else if (!empty($poruka)) {
                echo "<h3 style='text-align: center; color:green'>{$poruka}</h1>";
            }
        ?>
        
        <br>
        
        <br>
        
        <div class="row">
            <div class="col-7" style="text-align: center">
                <table class="table borderless" style="text-align: center;"> 
                    <tr style="text-align: center">
                        <td style="text-align: right; font-size: 20px; font-weight: bold;">Korisnicko ime: </td>
                        <td style="text-align: left; font-size: 20px;"><?php echo $klijent->korisnicko_ime; ?></td>
                    </tr>
                    <tr style="text-align: center">
                        <td style="text-align: right; font-size: 20px; font-weight: bold; ">Lozinka: </td>
                        <td style="text-align: left; font-size: 20px;"><?php for ($i = 0 ; $i < strlen($klijent->lozinka); $i++) echo "*" ?></td>
                        <?php 
                            if ($myProfile) {
                                echo "<td style='text-align: center;'><button class='btn btn-secondary' data-toggle='modal' data-target='#modalChangePassword'>Promeni lozinku</button></td>";
                            }
                        ?>
                    </tr>
                    <tr style="text-align: center">
                        <td style="text-align: right; font-size: 20px; font-weight: bold; ">Email: </td>
                        <td style="text-align: left; font-size: 20px;"><?php echo $klijent->email; ?></td>
                        <?php 
                            if ($myProfile) {
                                echo "<td style='text-align: center; '><button class='btn btn-secondary' data-toggle='modal' data-target='#modalChangeEmail'>&nbspPromeni email&nbsp</button></td>";
                                
                            }
                        ?>
                    </tr>
                    <tr style="text-align: center">
                        <td style="text-align: right; font-size: 20px; font-weight: bold; ">Broj telefona: </td>
                        <td style="text-align: left; font-size: 20px;"><?php echo $klijent->broj_telefona; ?></td>
                        <?php 
                            if ($myProfile) {
                                echo "<td style='text-align: center;'><button class='btn btn-secondary' data-toggle='modal' data-target='#modalChangeNumber'>&nbspPromeni &nbspbroj&nbsp</button></td>";
                            }
                        ?>
                    </tr>
                    
                    
                </table>
            </div>
            
            <div class="col-5" style="text-align: center">
                <table class="table borderless" style="text-align: center;">
                    <tr rowspan='3' style="text-align: center">
                        <td style="text-align: center">
                            <img  src="<?php 
                                if (!empty($_SESSION['slika_URL'])) echo baseUrlWithoutPublic.$_SESSION['slika_URL'];
                                    else echo baseUrlWithoutPublic."images/unknownuser.jpg"
                            ?> " style="height: 250px">
                        </td>

                    </tr>
                    <tr style="text-align: center">
                        <td style="text-align: center">
                            
                            <form action="<?php echo site_url('Klijent/uploadPicture')?>" method="post" enctype="multipart/form-data">
                                <table class="table borderless" style="text-align: center">
                                    <tr style="text-align: center">
                                        <td style="text-align: center">
                                            <input type="file" name="profileFile" id="profileFile" style="display: none" onchange="form.submit()"> 
                                            <label class="bg-secondary" for="profileFile" style="color:white; border-radius: 5px; padding: 10px">Dodaj profilnu sliku</label>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            
                        </td>
                    </tr>
                </table>
                
            </div>
        </div>
        
        <?php
            echo '<div class="modal" id="modalChangePassword">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title" >Promeni lozinku</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>                    

                            <div class="modal-body" style="text-align: center">
                                <form action="changePassword" method="post">
                                    <table class="table borderless" style="text-align:center">
                                        <tr>
                                            <td "><input type="password" placeholder="Stara lozinka" name="oldpassword" ></td>
                                        </tr>
                                        <tr>
                                            <td><input type="password" placeholder="Nova lozinka" name="newpassword"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="password" placeholder="Ponovi novu lozinku" name="repeteadpassword"></td>
                                        </tr>
                                        <tr>
                                            <td><button type="submit" class="btn btn-dark">Promeni lozinku</button></td>
                                        </tr>
                                    </table>                            
                                    
                                </form>
                             </div>

                        </div>
                    </div>
                </div>';   
            
           echo '<div class="modal" id="modalChangeEmail">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title" >Promeni email</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>                    

                            <div class="modal-body" style="text-align: center">
                                <form action="changeEmail" method="post">
                                    <table class="table borderless" style="text-align:center">
                                        <tr>
                                            <td "><input type="email" placeholder="Nova email adresa" name="newemail" ></td>
                                        </tr>
                                        <tr>
                                            <td><button type="submit" class="btn btn-dark">Promeni email</button></td>
                                        </tr>
                                    </table>                            
                                    
                                </form>
                             </div>

                        </div>
                    </div>
                </div>';
           
                echo '<div class="modal" id="modalChangeNumber">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title" >Promeni broj telefona</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>                    

                            <div class="modal-body" style="text-align: center">
                                <form action="changeNumber" method="post">
                                    <table class="table borderless" style="text-align:center">
                                        <tr>
                                            <td "><input type="tel" placeholder="Novi broj telefona" name="newphone" ></td>
                                        </tr>
                                        <tr>
                                            <td><button type="submit" class="btn btn-dark">Promeni broj</button></td>
                                        </tr>
                                    </table>                            
                                    
                                </form>
                             </div>

                        </div>
                    </div>
                </div>';
        ?>
        
        

        
    </div>
    

</body>
</html>