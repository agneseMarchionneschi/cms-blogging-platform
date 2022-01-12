<?php  include('../path.php'); ?>
<?php  include('../libs/database/config.php'); ?>
<?php  include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/uploadBlog.php'); ?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- ckeditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


<title>User| Create Blog</title>

</head>


<body>
<?php include('includes/navbar.php') ?>	


<?php $userID = $_SESSION['user']['id'] ?>

<?php include("../UserRegistrato/includes/messages.php") ?>

<div class ="page-wrlibser">
	<div class="containerCreateB text-center">
		<?php if (isset($_SESSION['user'])): ?>
            <h1><span><?php echo  $_SESSION['user']['username'] ?></span>, Inizia la creazione del tuo Blog &nbsp; &nbsp; </h1>
		<?php include('../UserRegistrato/includes/errors.php') ?>	

	 	<div style="display:none" id="msg_error" class= "message error validation_errors">
			<p>caratteri non validi </p>
		</div>

		
		
		
		<div class="formCrea my-5">
			<form id="form_creaB" action="createBlog.php" method="post" enctype="multipart/form-data">
			<div class="container-margine" >
				<div class="container my-4">
					<label> Inserisci il Titolo del tuo Blog</label> <br>
            		<input type="text" name="titolo" value ="<?php echo $titolo ?>" maxlength="30" autocomplete="off" />
				</div>
				<div class="container my-4 text-center">
					<label> Seleziona un'immagine per il tuo Blog:</label> <br>
					<div class="mb-3">
					<label for="formFile" class="form-label"></label>
  					<input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
					</div>	
				</div>
				<div id="containerCreateT" class = "containerCreateB">
					<div id="autocomplete" class="autocomplete">
						<label> Inserisci l'argomento del tuo Blog</label>
						<input id="myInput" class="form-control"  type="text" name="myTopic"  placeholder="Argomento" value="" maxlenght="20">
					</div>
				</div> <br>		
					<button type="button" class="btn btn-dark" id="CB_T"onclick="creaCheck();">Inserisci argomento</button>
				</div>
				<br><br><hr><br>
				<input type="submit" class="btn btn-dark" id="C_B" value="Crea Blog" name="submit">
			</form>
			
 	
 	
		</div>
	</div>
	<?php endif ?>
</div>			

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php include('../UserRegistrato/includes/footer.php') ?> 
<script src="../assets/js/ricerca.js">  </script>
</body> 
<script src="../assets/js/temi.js">  </script>
</html>