<?php include('path.php'); ?>
<?php include('libs/database/db.php'); ?>
<?php include('libs/includes/reglog.php') ?>
<!DOCTYPE html>
<html>
<head>

<!doctype html>
<html lang="en">
      <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Onblog - Create your blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="includes/css/stile.css" rel="stylesheet" >
  </head>
   <body>
  <?php include "includes/header.php" ?> 

	<form method="post" action="login.php">
  	<?php include('libs/includes/errors.php');//gestore errori ?>
	
	<main class="container">
		<div class="row m-0 h-100">
			<div class="col p-0 text-center d-flex justify-content-center align-items-center display-none">
			<img src="img/login.svg" class="w-100">
		</div>

		<div class="col p-0 bg-custom d-flex justify-content-center align-items-center flex-column w-100">
			<form class="w-75">
				<div class="mb-3">
					<label for="exampleFormControlInput1" class="form-label">Username</label>
					<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" autocomplete = "off" maxlength="30">
				</div>
				
				<div class="mb-3">	
					<label for="exampleFormControlInput2" class="form-label">Password</label>
					<input type="password" class="form-control" name="password" autocomplete = "off" maxlength="30">
				</div> </br>
			
			<button type="submit" id="logbtn" name="log_btn" class="btn btn-outline-dark">Login</button>
		
			<p>
				Non sei registrato? <a href="register.php">Registrati</a>
			</p>
		</form>
	</div>
	</div>
		</br></br>
		</main>
</body>
<?php include "includes/footer.php" ?> 
</html>