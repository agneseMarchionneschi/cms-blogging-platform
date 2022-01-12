<?php include('path.php'); ?>
<?php include('libs/database/db.php'); ?>
<?php include('libs/database/config.php'); ?>
<?php include('libs/includes/functions.php'); ?>


		
<!DOCTYPE html>
<html>
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
		<?php $blogs = getBlogs(); ?>

		<?php 




if (isset($_POST['ricerca_btn']))  { // il bottone ricerca viene premuto perchè diverso da null
  
  	//inizio controlli
	if(!isset($_POST['button'])){array_push($errors, "Inserisci un metodo di ricerca");}  //se non viene scelto un criterio con cui fare la ricerca da errore
	else {$scelta = $_POST['button']; } //altrimenti salva la scelta
	
	   $string = esc($_POST['topicOtitle']); //controllo
	   if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $string))  //preg_match permette di eseguire un controllo con le espressioni regolari
		{array_push($errors, "Inserisci caratteri validi"); } //se non solo validi allora da l'errore
	   $slug = makeslug($string); //funzione che rimuove gli spazi 
	if(empty($string)) { array_push($errors, "Inserisci un metodo di ricerca");}

	if (count($errors) == 0) {  //se non conta errori
   
		
		if ($scelta == "topics" ) { //se la scelta per cui ricercare è topic
			$blogs = getBlogbyTopicTitleName($string); //applica la funzione che cerca i blog attraverso i topic
			if(empty($blogs)){array_push($errors, "Nessuna corrispondenza"); } //se non ci sono corrispondenze applicate allora da l'errore
		}
		else if ($scelta == "titles"  ) { 
			$blogs = getBlogbyTopicTitleName($string);
			
			if(empty($blogs)){array_push($errors, "Nessuna corrispondenza"); }
		}
		else if ($scelta == "usernames" ) { 
			$blogs = getBlogbyUsername($string);
			if(empty($blogs)){array_push($errors, "Nessuna corrispondenza"); }

		}else{ array_push($errors, "No match");}
    }
}
	 
?>	
<h1 class="content-title">BLOGS:</h1>
 <div class="container">	

 <div class="row">
<div class="card"  id= "vie" style="text-align:left">
	<h2 id="sea">Cerca</h2>
  	<div id="bod" class="card-body">
			<form method="post" action="blog.php">
			<?php include('libs/includes/errors.php'); ?>
				<div class="form-check">
					<input type="radio" name="button" value="topics" onClick="GesAutocmp(this.value);">
					<label class="form-check-label" for="exampleRadios1"> Topic </label>
				</div>
				<div class="form-check">
				  <input type="radio" name="button" value="titles" onClick="GesAutocmp(this.value);"  >
				  <label class="form-check-label" for="exampleRadios2"> Titolo </label>
				</div>
				<div class="form-check">
				  <input  type="radio" name="button" value="usernames" onClick="GesAutocmp(this.value);">
				  <label  class="form-check-label" for="exampleRadios3"> Username </label>
			    </div>		
			<div class="autocomplete" >
  				<input type="text" name="topicOtitle" id="myInput" value="" autocomplete="off" maxlength="30" >
			</div>		
			<button type="submit" id="btpp" class="btn btn-primary" name="ricerca_btn">Cerca</button>
    		</form>
    </div>	
</div>
</div>



	<?php if(empty($blogs)){$blogs = getBlogs();}
	foreach ($blogs as $blog): ?>
<div class="container">


	<div id="divis" class="col-sm">
  
  <div id="visu" class="card" style="width: 18rem;">

				<?php $userID = $blog['user_id']  //inizializzo dei parametri?>
				<?php $imgID = $blog['image_id'] ?>
				<?php $blogID = $blog['id'] ?>
				<?php $src = getImageByID($imgID)?>
	<div class="card-body">
		<h3 id="titol" class="card-title"><?php echo $blog['title'] ?></h3>
				    <p>Writed by: <?php $username = getUsernameByBlogUserID($userID); ?></p>
				    <p>Argomento: <?php $topics = getBlogTopic($blogID); ?></p>
					<p><?php echo date("F j, Y ", strtotime($blog["created_at"])); ?>  </p>
					<a id="btp"class="btn btn-primary" id="puls" href="post.php?blog_id=<?php echo $blog['id']; ?>">Apri</a>
			<img class="card-img-top2"  src="assets/img/<?php echo $src?>" width="250" height="150">

</div></div></div>
</div>



</body>

	<?php endforeach?>




<script src="assets/js/ricerca.js">  </script>
<div class="fotor">
<?php include('includes/footer.php') ?>
</div>

</html>