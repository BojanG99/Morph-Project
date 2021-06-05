<?php?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="<?php echo baseUrlWithoutPublic."css/upload.css"?>" type="text/css"> 
</head>
<body>


<!--    <div class="container">
        <div class="row">
            <form action="" method="post">
                <h3>Ucitaj fajl</h3>
                <input type="file" name="myfile"><br>
                <button type="submit" name="save">Upload</button>
            </form>
        </div>
    </div>
-->
<?php echo $greska?>

<div class="frame">
    <form action="<?php echo site_url('Programer/staviFajlNaServer/'.$idZad);?>" enctype="multipart/form-data" method="POST">
	<div class="center">
		<div class="title">
			<h1>Drop file to upload</h1>
		</div>

		<div class="dropzone">
			<img src="images.png" class="upload-icon" />
			<input type="file" class="upload-input" name="file" />
		</div>

		<button type="submit" class="btn" name="save">Upload file</button>
    </form>
	</div>
</div>
</body>
</html>
