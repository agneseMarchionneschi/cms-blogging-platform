<?php include('path.php'); ?>
<?php include('libs/database/db.php'); ?>
<?php include('libs/database/config.php'); ?>
<?php include('libs/includes/functions.php'); ?>
<?php 
$targetIMGheader ="assets/img/header/";
$targetIMGsfondo ="assets/img/backgrounds/";



	if (isset($_GET['blog_id'])) {     //se è settato l'ID del blog restituisce i post di quel blog
		$posts = getBlogPosts($_GET['blog_id']);
		$title = getBlogTitle($_GET['blog_id']);
		$username = getBlogowner($_GET['blog_id']);
		$bg = getBackground($_GET['blog_id']);
		$header = getHeader($_GET['blog_id']);
		$topics =  getTopicsArray($_GET['blog_id']);		
	}
	else{
		$posts = getAllPosts(); //altrimenti restituisce tutti i post 
	}
?>
<?php //effettuo la ricerca dei post tramite il loro titolo	o username
   if (isset($_POST['ricerca_btn'])) { // viene premuto il bottone ricerca perchè diverso da null

	//inizio controlli
	if(!isset($_POST['button'])){array_push($errors, "inserisci criterio di ricerca");} //se non viene scelto un criterio con cui fare la ricerca da errore
	else {$scelta = $_POST['button']; } //altrimenti salva la scelta 

	$string = esc($_POST['topicOtitle']); //controllo

	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $string)) //preg_match permette di eseguire un controllo con le espressioni regolari
		{array_push($errors, "caratteri non validi"); } //se non solo validi allora da l'errore
	if(empty($string)) { array_push($errors, "inserisci topic o titolo");} //se non viene inserito niente da errore
	
	
	if (count($errors) == 0) {   //se non si contano errori
      
		 if ($scelta == "titlesP"  ) {  //la scelta per cui ricercare è il titolo
			$posts = getPostbyTitle($string); //applica la funzione che cerca i post attraverso i titoli
			if(empty($posts)){array_push($errors, "Nessuna corrispondenza,cambia criterio");  $posts = getAllPosts(); } //se non ci sono corrispondenze applicate allora da l'errore
		}
		else if ($scelta == "usernames" ) { 
			$posts = getPostbyUsername($string);
			if(empty($posts)){array_push($errors, "Nessuna corrispondenza,cambia criterio");  $posts = getAllPosts(); }

		}else{ array_push($errors, "Nessuna corrispondenza");} //se non si sceglie ne topic ne titolo da errore
    }
}

	
 ?>	

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Onblog - Create your blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="includes/css/stile.css" rel="stylesheet" >
      <?php include "includes/header.php" ?> 
<body style="background-image:url(<?php echo $targetIMGsfondo . $bg['0']; ?>);">

 <?php if (isset($title) ): ?>
 <div class = "personalBlogInfo" style="background-image:url( <?php echo $targetIMGheader . $header; ?>);">
   <br>         
   <h1><?php echo $title['0']; ?></h1>
   <p class="pBlog"><?php echo  "Benvenuto nel blog di ".$username['0'];?> </p><br>
   <?php else: ?>
	<br>
   <h1 class="content-title"> POSTS:</h1>
   <?php endif; ?>
 </div>

  </head>





<div class="container">	
	<div class="row">
	<div class="card"  id= "vie" style="width: 18rem;">
		<h2 id="sea1">Cerca</h2> </br>
	  	<div id="bod" class="card-body">
		<form method="post" action="post.php">
		<?php include('libs/includes/errors.php'); ?>


		<label>Titolo</label>
		<input type="radio" name="button" value="titlesP"onClick="GesAutocmp(this.value);" />
		<label>Username</label>
		<input type="radio" name="button" value="usernames"onClick="GesAutocmp(this.value);" />


		<div class="autocomplete" >
  			<input type="text" name="topicOtitle" id="myInput" value="" autocomplete="off" maxlength="30" >
		</div>		 
		<button type="submit" id="btpp1" class="btn btn-primary" name="ricerca_btn">Cerca</button>
        <br>
    </form>
 </div>
  </div>
  </div>

	   <?php foreach ($posts as $post): ?>


<div class="container">
<div id="divis" class="col-sm">
	  <div id="visu" class="card" style="width: 18rem;">
	    <?php $userID = $post['user_id']; //recupero gli ID di alcuni elementi del post?>
		<?php $imgID = $post['image_id'] ;?>
	
		<?php $src = getImageByID($imgID)?>


		  <h3 id="titol" class="card-title"><?php echo $post['title'] ?></h3><br>
		  <img  class = "card-img-top"src="assets/img/<?php echo $src?>" width="250" height="170">	<br>
				 <p>Pubblicato da: <?php $username = getUsernameByPostUserID($userID) ; ?></p>
				 <p><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></p> <br>
				 <a id="btp"class="btn btn-primary" id="puls"  href="openpost.php?post_id=<?php echo $post['id']; ?>"><span class="read_more">Leggi</span></a>
</div></div></div>

</body>
      <?php endforeach ?>


<script src="assets/js/ricerca.js">  </script>
<div class="fotorix">
	<?php include('includes/footer.php') ?>
	</div>

</html>