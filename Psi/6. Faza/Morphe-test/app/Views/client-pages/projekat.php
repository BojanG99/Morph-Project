<!-- Bojan Galic -->


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morphe</title>
    <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/style.css"?>" type="text/css">
     <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/klientProjekat.css"?>" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
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
    </div>
    
    
    <!--------------------->
    
    <div class="container main-section">
	<div class="row justify-content-md-center">
		<div class="col-lg-3 col-sm-4 col-12 text-center">
			<div class="row main-box-layout img-thumbnail">
				<div class="col-lg-12 col-sm-12 col-12 box-icon-section bg-primary">
					<i class="fa fa-tasks" aria-hidden="true"></i>
				</div>
				<div class="col-lg-12 col-sm-12 col-12 box-text-section">
					<p>Broj Zadataka</p>
				</div>
				<div class="label">
					<h3><span class="badge badge-pill bg-primary"><?php echo $brZad?></span></h3>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-4 col-12 text-center">
			<div class="row main-box-layout img-thumbnail">
				<div class="col-lg-12 col-sm-12 col-12 box-icon-section bg-warning">
					<i class="fa fa-tasks" aria-hidden="true"></i>
				</div>
				<div class="col-lg-12 col-sm-12 col-12 box-text-section">
					<p>Implementira se</p>
				</div>
				<div class="label">
					<h3><span class="badge badge-pill bg-warning"><?php echo $uImplementaciji?></span></h3>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-4 col-12 text-center">
			<div class="row main-box-layout img-thumbnail">
				<div class="col-lg-12 col-sm-12 col-12 box-icon-section bg-danger">
					<i class="fa fa-tasks" aria-hidden="true"></i>
				</div>
				<div class="col-lg-12 col-sm-12 col-12 box-text-section">
					<p>Testira se </p>
				</div>
				<div class="label">
					<h3><span class="badge badge-pill bg-danger"><?php echo $testiraSe?></span></h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-md-center">
		<div class="col-lg-3 col-sm-4 col-12 text-center">
			<div class="row main-box-layout img-thumbnail">
				<div class="col-lg-12 col-sm-12 col-12 box-icon-section bg-info">
					<i class="fa fa-tasks" aria-hidden="true"></i>
				</div>
				<div class="col-lg-12 col-sm-12 col-12 box-text-section">
					<p>Implementirano</p>
				</div>
				<div class="label">
					<h3><span class="badge badge-pill bg-info"><?php echo $implementirano?></span></h3>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-4 col-12 text-center">
			<div class="row main-box-layout img-thumbnail">
				<div class="col-lg-12 col-sm-12 col-12 box-icon-section bg-success">
					<i class="fa fa-percent" aria-hidden="true"></i>
				</div>
				<div class="col-lg-12 col-sm-12 col-12 box-text-section">
					<p>Procentualno zavrseno</p>
				</div>
				<div class="label">
					<h3><span class="badge badge-pill bg-success"><?php echo $procenat?></span></h3>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-4 col-12 text-center">
			<div class="row main-box-layout img-thumbnail">
				<div class="col-lg-12 col-sm-12 col-12 box-icon-section bg-secondary">
					<i class="fa fa-user-times" aria-hidden="true"></i>
				</div>
				<div class="col-lg-12 col-sm-12 col-12 box-text-section">
					<p>Broj programera</p>
				</div>
				<div class="label">
					<h3><span class="badge badge-pill bg-secondary"><?php echo $numProgramera?></span></h3>
				</div>
			</div>
		</div>
	</div>
</div>
    
    
    
    
    
</body>
</html>