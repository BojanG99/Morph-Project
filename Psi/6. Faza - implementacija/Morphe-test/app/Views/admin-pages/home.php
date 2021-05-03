<?php helper("url")?>

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
  

</head>
<body style="background-color: blanchedalmond;">
    
    <div class="container-fluid">
        <div class="row" id="header" style="padding-top: 1%;">
            <div class="col-1" style="text-align: center; vertical-align: middle;">
                <img src="<?php echo baseUrlWithoutPublic."images/logo.png"?>" style="height: 90px;"> 
            </div>

            <div class="col-1 offset-8 offset-md-9" style="text-align: center;">
                <img src="
                        <?php 
                            if (!empty($_SESSION['slika_URL'])) echo baseUrlWithoutPublic.$_SESSION['slika_URL'];
                                else echo baseUrlWithoutPublic."images/unknownuser.jpg"
                        ?> " 
                    style="height: 55px;">
                
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
                        <a class="dropdown-item" href="<?php echo site_url('Admin/index')?>">Pocetna</a>
                        <a class="dropdown-item" href="<?php echo site_url('Admin/logout')?>">Izloguj se</a>
                    </div>
                </div>
            </div>

        </div>

            <br>

            <div class="row">
                <div class="col" style="text-align: center; font-weight: bolder; font-size: 35px;">
                    <h1>Korisnici</h1>
                </div>
            </div>

            <br>
            <br>


            <div class="row">
                <div class="col">
                    <table class="table table-striped table-bordered" style="text-align: center; background-color: #c8e2e2;">
                        <tr>
                            <th></th>
                            <th>Korisnicko ime</th>
                            <th>Email</th>
                            <th>Broj telefona</th>
                            <th>Tip</th>
                            <th></th>
                            <th></th>

                        </tr>
                        <?php 
                            $idKor = 1;
                            
                            
                            foreach ($korisniciNaCekanju as $korisnik) {
                                $urlPrihvati = site_url('Admin/acceptUser')."/".$korisnik->korisnicko_ime;
                                $urlOdbij = site_url('Admin/declineUser')."/".$korisnik->korisnicko_ime;
                             echo "   <tr>
                                        <td>{$idKor}</td>
                                        <td>{$korisnik->korisnicko_ime}</td>
                                        <td>{$korisnik->email}</td>
                                        <td>{$korisnik->broj_telefona}</td>
                                        <td>{$korisnik->tip}</td>
                                        <td>
                                            <button type='button' class='btn btn-dark forma' onClick=".'"location.href='."'{$urlPrihvati}'".'"'.">Prihvati</button>
                                        </td>
                                        <td>
                                            <button type='button' class='btn btn-dark forma' onClick=".'"location.href='."'{$urlOdbij}'".'"'.">Odbij</button>
                                        </td>
                                    </tr> ";
                                        
                                      $idKor++;
                            }
                            
                            foreach ($programeri as $korisnik) {
                                $urlObrisi = site_url('Admin/deleteUser')."/".$korisnik->korisnicko_ime;
                             echo "   <tr>
                                        <td>{$idKor}</td>
                                        <td>{$korisnik->korisnicko_ime}</td>
                                        <td>{$korisnik->email}</td>
                                        <td>{$korisnik->broj_telefona}</td>
                                        <td>Programer</td>
                                        <td colspan='2'>
                                            <button type='button' class='btn btn-dark forma' onClick=".'"location.href='."'{$urlObrisi}'".'"'.">Obrisi</button>
                                        </td>
                                      </tr> ";
                                        
                                      $idKor++;
                            }
                            
                            foreach ($menadzeri as $korisnik) {
                                $urlObrisi = site_url('Admin/deleteUser')."/".$korisnik->korisnicko_ime;
                             echo "   <tr>
                                        <td>{$idKor}</td>
                                        <td>{$korisnik->korisnicko_ime}</td>
                                        <td>{$korisnik->email}</td>
                                        <td>{$korisnik->broj_telefona}</td>
                                        <td>Menadzer</td>
                                        <td colspan='2'>
                                            <button type='button' class='btn btn-dark forma' onClick=".'"location.href='."'{$urlObrisi}'".'"'.">Obrisi</button>
                                        </td>
                                      </tr> ";
                                        
                                      $idKor++;
                            }
                            
                            foreach ($klijenti as $korisnik) {
                                $urlObrisi = site_url('Admin/deleteUser')."/".$korisnik->korisnicko_ime;
                             echo "   <tr>
                                        <td>{$idKor}</td>
                                        <td>{$korisnik->korisnicko_ime}</td>
                                        <td>{$korisnik->email}</td>
                                        <td>{$korisnik->broj_telefona}</td>
                                        <td>Klijent</td>
                                        <td colspan='2'>
                                            <button type='button' class='btn btn-dark forma' onClick=".'"location.href='."'{$urlObrisi}'".'"'.">Obrisi</button>
                                        </td>
                                      </tr> ";
                                        
                                      $idKor++;
                            }
                            
                        
                        ?>
                
                        

                    </table>
                </div>
            </div>
        
        

        
    </div>
    

</body>
</html>