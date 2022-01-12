<?php ob_end_flush(); //Svuota il buffer di output e lo disattiva  ?>
<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php require_once('../path.php'); ?>

<?php include('../UserRegistrato/includes/userfunction.php'); ?>
<?php 
$targetIMGheader ="../assets/img/header/";
$targetIMGsfondo ="../assets/img/backgrounds/";

$user = $_SESSION['user']['id'];
$blogs = getMyBlog($user);

if (isset($_GET['blog_id'])) { //se è settato l'id del blog restituisce solo i post di quel blog
		$posts = getBlogPosts($_GET['blog_id']); 
		$blog = $_GET['blog_id'];
		$title = getBlogTitle($_GET['blog_id']);
		$username = getBlogowner($_GET['blog_id']);
		$bg = getBackground($_GET['blog_id']);
		$header = getHeader($_GET['blog_id']);
		$topics =  getTopicsArray($_GET['blog_id']);
	}else{
		$posts = getAllPosts(); //altrimenti vengono restituiti tutti 
	}

//RICERCA
if (isset($_POST['ricerca_btn'])) { //se il bottone viene premuto (ha valore diverso da null)
//print_r($_POST);
 if(!isset($_POST['button'])){array_push($errors, "inserisci criterio di ricerca");} //se non viene scelto un criterio con cui fare la ricerca dei post da errore
 else {$scelta = $_POST['button']; } //altrimenti salva la scelta 

 $string = esc($_POST['title']); //controllo 
 if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $string)) //preg_match permette di eseguire un controllo con le espressioni regolari
	{array_push($errors, "caratteri non validi"); } //se non solo validi allora da l'errore
 if(empty($string)) { array_push($errors, "inserisci topic o titolo");}


 if (count($errors) == 0) {  //se non conta errori
  
	if ($scelta == "titlesPU"  ) { //se la scelta per cui ricercare è il titolo
		$posts = getPostbyTitle($string); //applica la funzione che cerca i post attraverso i titoli
	}
	if ($scelta == "usernamesU" ) { //se la scelta per cui ricercare è l'username
		$posts = getPostbyUsername($string); //applica la funzione che cerca i post attraverso gli username
	}
	if(is_null($posts)){
		array_push($errors, "Nessuna corrispondenza"); //se non ci sono corrispondenze applicate allora da l'errore
		$posts = getAllPosts(); //allora ritorna tutti i posts
		
	}
 }
}
?>
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


<?php 
if(isset($_GET['blog_id'])){ ?>
	<body style="background-image:url(<?php echo $targetIMGsfondo . $bg['0']; ?>);">
<?php
}else{ ?>
	<body>
<?php
} ?>

<?php include('includes/navbar.php') ?>


<div class="page-wrlibser">
	<?php if (isset($title) ): ?>
		<div class = "personalBlogInfo" style="background-image:url( <?php echo $targetIMGheader . $header; ?>);">
	  	<br> 
        
			<p class="content-title" ><?php echo  "Benvenuto nel blog di ".$username['0'];?> </p><br>
			<h2 class="sottotitoloTopic"><?php echo $title['0']; ?></h2>
		</div><br>
	
	<?php else: ?>
		<h2 class="content-title"> Posts </h2>
	<?php endif; ?>
	<div>
		
	
	<div class="menu text-center">
			<h2 style="margin-bottom:2%;">Ricerca un titolo o username</h2>
			
			<form method="post" action="all_post.php">
		<?php include('../UserRegistrato/includes/errors.php') ?>
				<input type="radio" id="radio1" name="button" value="titlesPU" onClick="GesAutocmp(this.value);"/> Titolo <br>
				<input type="radio" id="radio2" name="button" value="usernamesU" onClick="GesAutocmp(this.value);" /> Username<br>
				<div class="autocomplete my-2 text-center">
				<input class= "ricerca" type="text" id="myInput" name="title" value="" autocomplete = "off" maxlength="30" >
				</div>
				<button type="submit" class="btn btn-dark " name="ricerca_btn">Trova</button>
		    </form>
		
	</div>
	
		<?php if (isset($_GET['blog_id'])) { 
			$result1 = mysqli_query($conn, "SELECT * FROM blogs WHERE user_id = $user AND id= $blog"); 
			$result2 = mysqli_query($conn, "SELECT * FROM coautore WHERE blog_id= $blog AND user_id =$user"); 
			if (mysqli_num_rows($result1) == 1 || mysqli_num_rows($result2) == 1  ): ?>	
			<br><hr><br>
			<div class="containerSpan">
				<span style="display:none;" id="blog"><?php echo $_GET['blog_id']?></span>
				<a id="bottonee" href="gestisci_blog.php?blog_id=<?php echo $_GET['blog_id']?>" class="creabtnCB"><span>Gestisci blog</span> </a><br>
				<a id="bottonee" href="creaPost.php?blog_id=<?php echo $_GET['blog_id']?>" class="creabtnCB"><span>Crea Post</span> </a>
			
		<?php endif;} ?>
	</div>
	
<?php 
	if($posts){ ?>
		<div class="row mb-2">
			
<?php 			foreach ($posts as $post): ?>
			    	<?php $userID = $post['user_id'];
					$imgID = $post['image_id'] ;
					$src = getImageByID($imgID)?>
					<div class="card" style="width: 18rem;">
						<img class="card-img-top" src="../assets/img/<?=$src?>"  alt="Card image cap">
						<h3><?php if(strlen( $post['title'])<13):
						echo $post['title'];
					else:
						echo(substr($post['title'],0,15)."..");
					endif; ?></h3><br>	
	    	            <div class="Post_info">
							<p> Scritto da: <?php $username = getUsernameByPostUserID($userID) ; ?></p>
						 	<p><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></p> <br>
							<a href="open_post.php?post_id=<?php echo $post['id']; ?>"><span class="read_more"> Leggi altro</span></a>
						</div>
						<br>
					</div>
<?php
				endforeach ?>
			
		</div>
<?php
	}else{ ?>
		<div class="riempi"></div>
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


