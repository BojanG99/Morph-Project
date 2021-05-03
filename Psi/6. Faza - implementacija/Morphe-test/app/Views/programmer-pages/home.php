<?php helper("url");
$brojKonkursaURedu = 2;
?>

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
                        <a class="dropdown-item" href="<?php echo site_url('Programer/chat')?>">Razgovori</a>
                        <a class="dropdown-item" href="<?php echo site_url('Programer/logout')?>">Izloguj se</a>
                    </div>
                </div>
            </div>

        </div>

        <br>
        
        <br>

            <div class="row">
                <div class="col-8" >
                    <form action="<?php echo site_url('Programer/pretrazaKonkursa') ?>" method="post" name="pretraziMenadzereForm">
                       <table class="table borderless" style="text-align: center;">
                           <tr>
                               <td colspan="2">
                                    <h2>Pretraga konkursa</h2>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" placeholder="Programski jezik" name="programskiJezik" />
                                </td>

                            </tr>
                 
                            
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-dark forma">Pretraga</button>
                                </td>

                            </tr>
                        </table> 
                    </form>
                    
                </div>
            </div>
        
            <div class="row">
                <div class="col-8" style="text-align: center">
                    
                    <?php 
                        if (!empty($greska)) {
                            echo "<h2 style='color:red;'>$greska</h2>";
                        }else if (!empty ($poruka)) {
                            echo "<h2 style='color:green'>$poruka</h2>";
                        }
                        else if (!empty($konkursi)) {
                            $count = 0;
                            echo "<table style='width: 100%'>";
                            foreach($konkursi as $konkurs) {
                                $urlPrijave = site_url('Programer/prijaviSeNaKonkurs/').$konkurs->idKon;
                                $urlKorisnika = site_url('Programer/profile/').$konkurs->korisnicko_ime;
                                if ($count == 0) echo "<tr style='display: flex; justify-content: space-around'>";
                                echo "<td style='margin: 1%; '>
                                        <table class='table borderless' style='background-color: lightsteelblue; '>
                                            <tr>
                                                <td>Klijent: </td>
                                                <td>{$konkurs->korisnicko_ime}</td>
                                                <td><a href='"."{$urlKorisnika}"."'>Profile</a></td>
                                            </tr>
                                            <tr>
                                                <td>Jezik: </td>
                                                <td colspan='2'>{$konkurs->naziv}</td>
                                            </tr>
                                            <tr>
                                                <td>Opis: </td>
                                                <td colspan='2'>{$konkurs->opis}</td>
                                            </tr>
                                            <tr>
                                                <td>Rok: </td>
                                                <td colspan='2'>{$konkurs->vreme_kraja}</td>
                                            </tr>";
                                                
                            if (isset($izbaciKonkurse) && !in_array($konkurs->idKon, $izbaciKonkurse)) {
                                echo "<tr >
                            
                                                    <td colspan='3' style='text-align:center'>
                                                        <button type='button' class='bnt' onClick=".'"location.href='."'{$urlPrijave}'".'"'.">Prijavi se</button>
                                                    </td>

                                                 </tr>";
                            }
                                echo "</table>
                                </td>";
                             
                                if ($count == $brojKonkursaURedu - 1) echo "</tr>";
                                $count = ($count + 1) % $brojKonkursaURedu;
                            }
                            
                            echo "</table>";
                        }
                    
                    ?>
                    
                </div>
                
               
            </div>
            

        
    </div>
    

</body>
</html>