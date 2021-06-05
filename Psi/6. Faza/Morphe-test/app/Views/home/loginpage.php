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
        <div class="row" id="header">
            <div class="col-1" style="text-align: center; vertical-align: middle; padding-top: 1%;">
                <img src="<?php echo baseUrlWithoutPublic."images/logo.png"?>" style="height: 55px;"> 
            </div>
            <div class="col-2 offset-5 col-md-1 offset-md-7 offset-lg-8 headerlink" >
                
                <a href="<?php echo site_url('Home/loginpage')?>" id="register">Prijava</a>
            </div>
            <div class="col-2 col-md-1 offset-md-1 offset-lg-0 headerlink">
                <a href="<?php echo site_url('Home/registerpage')?>" id="register">Registracija</a>
            </div>
        </div>


        <div class="row">
            <div class="col-6 offset-3" style="margin-top: 5%">
                <form action="<?php echo site_url('Home/login')?>" method="post" name="loginform">
                    <table class="table table-bordered" style="text-align: center; background-color: #c8e2e2;">
                    <tr >
                        <th colspan="3" style="font-size: 30px; font-weight: bold; padding-top: 8%">Uloguj se!</th>
                    </tr>
                    <?php 
                        
                        if (!empty($greska)) {
                            echo "<tr >".
               
                            '<th colspan="3" style="color: red; font-size: 20px; font-weight: bold; padding-top: 3%; padding-bottom: 3%;">';
                                  echo $greska;
                            echo "</th>".
                            "</tr>";
                        }
                            
                    ?>
                    <tr>
                        <td colspan="3"><input type="text" id="usernameinput" name="usernameinput" class="forma" placeholder="Korisnicko ime"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="password" id="passwordinput" name="passwordinput" class="forma"placeholder="Lozinka"></td>
                    </tr>
                   
                    <tr>
                        <td colspan="3">
                            <button type="submit" class="btn btn-dark forma">Uloguj se</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><a href="<?php echo site_url('Home/registerpage')?>" style="color: black; font-size: small; vertical-align: middle; text-decoration: underline;">Nemas nalog? Registruj se</a></p>
                        </td>
                    </tr>
                </table>
                </form>
                
            </div>
        </div>
        
    </div>

    

</body>
</html>