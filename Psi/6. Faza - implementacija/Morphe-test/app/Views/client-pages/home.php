<?php helper("url");
   $maxManagersInRow = 4;
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
        
        <br>

            <div class="row">
                <div class="col-8" >
                    <form action="<?php echo site_url('Klijent/pretraziMenadzere') ?>" method="post" name="pretraziMenadzereForm">
                       <table class="table borderless" style="text-align: center;">
                           <tr>
                               <td colspan="2">
                                    <h2>Pretraga menadzera</h2>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" placeholder="Korisnicko ime" name="nazivMenadzera" />
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="sortitajMenadzere" value="Sortiraj po oceni rastuce"> Sortiraj po oceni rastuce
                                </td>
                                <td>
                                    <input type="radio" name="sortitajMenadzere" value="Sortiraj po korisnickom imenu rastuce"/> Sortiraj po korisnickom imenu rastuce
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" name="sortitajMenadzere" value="Sortiraj po oceni opadajuce"> Sortiraj po oceni opadajuce
                                </td>
                                <td>
                                    <input type="radio" name="sortitajMenadzere" value="Sortiraj po korisnickom imenu opadajuce"/> Sortiraj po korisnickom imenu opadajuce
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
                <div class="col-8" >
                    
                    <?php 
                        if (!empty($menadzeri)) {
                            $count = 0;
                            echo "<table style='width: 100%'>";
                            foreach($menadzeri as $menadzer) {
                                $urlProfila = site_url('Klijent/profile/').$menadzer->korisnicko_ime;
                                if ($count == 0) echo "<tr style='display: flex; justify-content: space-around'>";
                                echo "<td >
                                        <table class='table borderless' style='background-color: lightsteelblue; '>
                                            <tr>
                                                <td>Menadzer: </td>
                                                <td><a href='{$urlProfila}' style='color: black'>{$menadzer->korisnicko_ime}</a></td>
                                            </tr>
                                            <tr>
                                                <td>Ocena: </td>
                                                <td>{$menadzer->prosecna_ocena} / 10</td>
                                            </tr>
                                            <tr >
                                                <td colspan='2' style='text-align:center'>
                                                    <a href='' style='text-decoration: underline'>Posalji poruku</a> 
                                            </td>

                                    </tr>
                                </table>
                                </td>";
                             
                                if ($count == $maxManagersInRow - 1) echo "</tr>";
                                $count = ($count + 1) % $maxManagersInRow;
                            }
                            
                            echo "</table>";
                        }
                    
                    ?>
                    
                </div>
                
               
            </div>
        
        
        <div class="row">
            <div class="col-8">
                
            </div>
            
            <div class="col-4">
                
            </div>
            
        </div>

        
    </div>
    

</body>
</html>