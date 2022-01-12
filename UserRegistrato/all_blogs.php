<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>



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

</head>


<body> 
	
<?php include('../UserRegistrato/includes/navbar.php') ?>


<?php 

$blogs = getBlogs(); //vengono dati tutti i blog 

if(isset($_POST['ricerca_btn'])){  // viene premuto il bottone ricerca 
	if(!isset($_POST['button'])){array_push($errors, "inserisci criterio di ricerca");} //se non viene scelto un criterio con cui fare la ricerca dei blog da errore
	else {$scelta = $_POST['button']; //altrimenti la scelta del criterio viene salvata 
	
		//eseguo un controllo sulle stringhe
	   	$string = esc($_POST['topicOtitle']);
	   	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $string))  //preg_match permette di eseguire un controllo con le espressioni regolari
		{array_push($errors, "caratteri non validi"); } //se sono presenti caratteri non validi restituisce il seguente errore
	   	$slug = makeslug($string); //controllo
		if(empty($string)) { array_push($errors, "inserisci argomento o titolo");} //se non viene inserito nulla viene restituito il seguente errore
	}
	if (count($errors) == 0) {  //se conta zero errori
   
		if ($scelta == "topicsU" ) {  //se la scelta è di ricercare attraverso il topic
			$blogs = getBlogbyTopicTitleName($string); //ritorna i blog per topic con la seguente funzione
			if(empty($blogs)){array_push($errors, "Nessuna corrispondenza,cambia criterio"); } //se la variabile è vuota allora restituisce l'errore di nessuna corrispondenza
		}
		else if ($scelta == "titlesU"  ) { //se la scelta è di ricercare attraverso i titolo
			$blogs = getBlogbyTopicTitleName($string); //ritorna i blog per titolo con la seguente funzione 
			if(empty($blogs)){array_push($errors, "Nessuna corrispondenza,cambia criterio"); } //se la variabile è vuota allora restituisce l'errore di nessuna corrispondenza
		}
		else if ($scelta == "usernamesU" ) {  //se la scelta è di ricercare attraverso l'username
			$blogs = getBlogbyUsername($string); //ritorna i blog per username con la seguente funzione 
			if(empty($blogs)){array_push($errors, "Nessuna corrispondenza,cambia criterio"); } //se la variabile è vuota allora restituisce l'errore di nessuna corrispondenza

		}else{ array_push($errors, "Non c'è nessuna corrispondenza");}  //altrimenti restituisce il seguente errore
    }
}

?>

<div class="page-wrlibser1">
	<h2 class="content-title">Blogs</h2>
	<div class="menu text-center">
		<h2>Cerca un argomento/titolo/username</h2>
	
		<form method="post" id="formRic" action="all_blogs.php">
		<?php include('../UserRegistrato/includes/errors.php'); ?>
			<br>
			<input type="radio" id="radio1" name="button" value="topicsU" onClick="GesAutocmp(this.value);"/> Argomento<br>

			<input type="radio" id="radio2" name="button" value="titlesU" onClick="GesAutocmp(this.value);"/> Titolo<br>

			<input type="radio" id="radio3" name="button" value="usernamesU" onClick="GesAutocmp(this.value);"/> Username <br>
			<div class="autocomplete my-4 ">
  				<input type="text" name="topicOtitle" id="myInput" value="" autocomplete="off">
			</div>
			<button type="submit" class="btn btn-dark " name="ricerca_btn">trova</button>
        	<br>
		</form>
	</div>
       
		
	<br><hr><br>
	<div class="containerSpan">
	<a href="createBlog.php" id="bottonee" class="creabtnCB"><span>Crea un nuovo Blog </span> </a>
	</div>
	<br>
<?php 
	if(empty($blogs)){ ?>
		<div class="riempi"></div>
<?php
	}else{ ?>

	<div class="row mb-2">
		<?php
			foreach ($blogs as $blog): ?>
				<?php $userID = $blog['user_id']  //inizializzo dei parametri?>
					<?php $imgID = $blog['image_id'] ?>
					<?php $blogID = $blog['id'] ?>
					<?php $src = getImageByID($imgID)?>
					<div class="card" style="width: 18rem;" >

					<img class="card-img-top" src="../assets/img/<?=$src?>"  alt="Card image cap">
					<div class="card-body">
					<h5 class="card-title" id="tit"><?php echo $blog['title'] ?></h5>
	            	<div class="Blog_info">
						<p> Scritto da: <?php $username = getUsernameByBlogUserID($userID); ?></p>
						<p> Argomento: <?php $topics = getBlogTopic($blogID); ?></p>
						<p><?php echo date("F j, Y ", strtotime($blog["created_at"])); ?></p>
						<a href="all_post.php?blog_id=<?php echo $blog['id']; ?>">
						<span class="read_more">Leggi altro</span><br>
						</a>
					</div>
					</div>
				</div>	
	<?php 
			endforeach ?>
		</div>
	</div>
<?php
	} ?>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../assets/js/ricerca.js">  </script>
<?php include('../UserRegistrato/includes/footer.php') ?> 
</html>
