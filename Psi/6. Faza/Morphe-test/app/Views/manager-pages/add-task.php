<!-- Bojan Galic -->


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
    <br>
    <p> <?php
        echo $greske;
        ?></p>
    <br>
    
    <form action="<?php echo site_url("Menadzer/sacuvajZadatak") ?>" method="post">
  <div class="form-group">
    <label for="exampleFormControlInput1">Unesi naziv i ekstenziju fajla</label>
    <input type="text" class="form-control" name="file" placeholder="example.php">
  </div>
        <div class="form-group">
    <label for="exampleFormControlInput1">Unesi naziv i ekstenziju fajla</label>
    <input type="text" class="form-control" name="path" placeholder="C:\projects\nameofproject\programer\..your input">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Izaberite programera </label>
    <select class="form-control" name="option">
      <?php
    for($i=0;$i<count($programeri);$i++){

        echo "<option>".$programeri[$i]->idProgramera."</option>";
}
?>
    </select>
  </div>

       
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Opis zadatka</label>
    <textarea class="form-control" name="tasktext" rows="3"></textarea>
  </div>
        <button type="submit">Dodaj Zadatak</button>
</form>
    
</body>
</html>