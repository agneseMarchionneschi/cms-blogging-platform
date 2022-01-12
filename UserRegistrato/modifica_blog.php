<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../path.php'); ?>
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
<?php $userID = $_SESSION['user']['id'];
$blogs = getMyBlogPlusMeCoaut($userID);
$blogs_id = [];
foreach($blogs as $blog){ //creo un array di ID per stabilire a quali posso accedere 
	array_push($blogs_id, $blog['id']);
}
//serve per garantire la sicurezza nella gestione dei blog
if (isset($_GET['blog_id']) && in_array($_GET['blog_id'], $blogs_id)) {
		$blogID = $_GET['blog_id'];//se è settato il blog ID ed è nell'array creato sopra restituisco i post
		$posts = getBlogPosts($blogID); 
}else{ 
	header('Location:'. BASE_URL. '/UserRegistrato/dashboard.php'); //altrimenti ritorno alla dashboard
	exit;
}
include('includes/modificaBlog.php');
$images = getAllImage();

$blog =  getMyBlog($userID);
$src = getImageByblogID($blogID); 
$coaut = getCoautbyBlogID($blogID);
?>

	<?php include('../UserRegistrato/includes/navbar.php') ?>

	<div class="page-wrlibser">
		<h2 class="content-title">Personalizza il tuo blog</h2>
<br>
		<div class="divLayout">
		<a id="bottonee" href="layout.php?blog_id=<?php echo $blogID?>" class="btnLay"><span>Personalizza</span> <br></a></div>

	<?php include('../UserRegistrato/includes/errors.php') ?>

		<div style="display: none" id="msg_error"class="message error validation_errors" >
			<p>Caratteri non validi</p>
		</div>	
	<hr>
	<br><br>
		<h2 class="content-title2">Modifica titolo</h2>
		<br>
		<div class="divRicerca text-center">
		<form method="post" action="">
			<input class= "ricerca" type="text" name="cambiaTitolo" autocomplete="off" placeholder ="<?php $title=getitleBlog($blogID); ?>" maxlength="30" >
			<button type="submit" class="btn btn-dark" name="ModCambiatitolo_btn">Modifica</button><br>
		</form>
		</div>
		<br><br><br>

		<br><br>	
		<br><br>
		<hr>
		<br><br>
		<h2 class="content-title2">Modifica Argomento</h2><br>

<?php $topics = getBlogTopicArray($blogID);?>
	<div class="containerChangeTopic text-center">
		<form autocomplete="off" action="" name="form_tema" id="form_tema" method="post">
			<div class="containerCreateB text-center" id="containerCreateT">
				<?php foreach($topics as $topic): {?>
					<label class="container"><?php echo $topic['nome'];?>
						<input type="checkbox" checked="checked" name="temi_list[]" value="<?php echo $topic['nome'];?>"/>
						<span class="checkmark"></span>
					</label>
				<?php } endforeach ?>
				<p>Scegli un argomento o più e premi il pulsante <b>Aggiungi Argomento </b>per visualizzare la lista di argomenti, poi aggiungi un flag a quello che decidi di inserire e premi <b>Salva Argomento</b>. </p><br>
				<div id="autocomplete" class="autocomplete">
					<label>Inserisci il/gli argomento/i trattato/i dal tuo Blog</label>
					<input id="myInput" type="text" name="myTopic" placeholder="Inserisci Topic" value="" maxlenght="20"/> 
				</div>
			</div>
			
			<input type="submit" class="btn btn-dark"name="mod_tm" value="Salva Argomento">
			<button type="button" class="btn btn-dark" onclick="creaCheck();">Aggiungi Argomento</button>
		</form>
		</div>
		<br><br><br>
		<hr>
		<br><br>




		<h2 class="content-title2">Modifica icona del blog</h2><br>
    <div class="formCambia text-center">
     <form action="" method="post" >	
     <input type="text" list="listaimmagini" id="immagini" autocomplete = "off" name="fileToUpload" placeholder=" <?php echo $src['0'] ?>" >
     <datalist id="listaimmagini">
     <?php foreach ($images  as $img): // questo ciclo è utilizzato per far riempire la datalist con le varie opzioni?>
        <?php $imgName  = $img['src'];//assegno il nome dell'immagine a una variabile?>
        <option value="<?php echo $imgName  ?>"> <?php echo $imgName ?> </option>
	 <?php endforeach ?>
     </datalist>

     <input type="submit" class="btn btn-dark"value="Modifica" name="cambiaimg">
     </form>
 </div>
 <br><br>






	</div>
	
	<?php include('../UserRegistrato/includes/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body> 
<script src="../assets/js/temi.js">  </script>
</html>