<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>
<?php include('../UserRegistrato/includes/modificaUsers.php'); ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet" type="text/css">
<!-- Font awesome -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- ckeditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>



<title>Gestione utente</title>
</head>
<?php $username = $_SESSION['user']['username'];//prendo i valori delle variabili da quelle di sessione?>
<?php $email = $_SESSION['user']['email'];?>
<?php $password = $_SESSION['user']['password'];?>
<?php $cellulare = $_SESSION['user']['cellulare'];?>
<?php $documento = $_SESSION['user']['documento'];?>
<body>
<?php include('../UserRegistrato/includes/navbar.php') ?>
	
	
<div class="containerUser text-center">
		<h1 class="page-title">Cambia/Elimina il tuo Account</h1><br>
		<p> Dopo aver salvato le modifiche verrai reindirizzato alla pagina di login per confermare le nuove credenziali </p>
		 <br>
		<?php include('../UserRegistrato/includes/errors.php') ?>
		<form method="post" action="user.php" onsubmit="return Conferma_eliminazione()">
			<div class="container">
				<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" placeholder="Nome" autocomplete="off" size=40> <br>
				<input type="text" class="form-control" name="email" value="<?php echo $email ?>" placeholder="Email" autocomplete="off" size=40> <br>
				<input type="text" class="form-control" name="password" placeholder="Password" autocomplete="off" size=40> <br>
				<input type="text" class="form-control" name="cellulare" placeholder="Cellulare" value="<?php echo $cellulare ?>" placeholder="cellulare" autocomplete="off"  size=40> <br>
				<input type="text" class="form-control" name="documento" placeholder="Documento" value="<?php echo $documento ?>" placeholder="documento" autocomplete="off"  size=40> <br>
				</div>
			<div class="conteiner my-4">
			<button type="submit" class="btn btn-dark" name="modifica_btn" >Cambia</button> <br><br>
			<button type="submit" class="btn btn-dark" name="cancella_btn" >Elimina utente</button>	<br>
			</div>
		</form>	
	</div>

<?php include('../UserRegistrato/includes/footer.php'); ?>

</body>
<script type="text/javascript">
function Conferma_eliminazione(){
	
	var domanda = confirm("i dati non saranno recuperabili,continuare?");
	
	if (domanda==true){
		alert('modifica/cancellazione eseguita');
		return true;
	}
	else{
		alert('modifica/cancellazione non eseguita');
		return false;
	}
}
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>