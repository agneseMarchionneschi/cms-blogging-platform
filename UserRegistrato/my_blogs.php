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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- ckeditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


</head>

<?php 
	$userID = $_SESSION['user']['id'];
	$blogs = getMyBlogPlusMeCoaut($userID);
?>

<body> 
	
<?php include('../UserRegistrato/includes/navbar.php') ?>

<div class ="container">
	<h2 class="content-title"> I miei Blog</h2>
	<div class="page-wrlibser">
      <div class="col-md-3">
        <a class="btn btn-primary btn-block" mb-3" href="createBlog.php" class="first"><span></i>Crea un nuovo Blog</span> <br></a> </div>
      <div class="col-md-3">
        <a class="btn btn-primary btn-block" href="user.php"><span></i> Gestione utente</span></i><br></a></div>
      <div class="col-md-3">
        <a class="btn btn-primary btn-block" href="all_blogs.php"><span></i>Cerca un Blog</span> <br></a> </div>
    </div> <br><br><br><br><br></a>


<div class="containerDashboard2">
<div class="row mb-2">
<?php
	if(empty($blogs)){ ?>
	
<?php
	}else{
		foreach ($blogs as $blog): ?>
		<?php $imgID = $blog['image_id'] ?>
		<?php $src = getImageByID($imgID)?>


  <div class="card" style="width: 18rem;">
    <img class="card-img-top" src="../assets/img/<?=$src?>"  alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title" id="tit"><?php echo $blog['title'] ?></h5>
    <p class="card-text" id="date"><span><?php echo date("j F, Y ", strtotime($blog["created_at"])); ?></span></p>
	<a href="gestisci_blog.php?blog_id=<?php echo $blog['id'];?>" class="btnModBlog"><span class="modifica">Modifica</span></a> 
	<a href="all_post.php?blog_id=<?php echo $blog['id']; ?>"><br>
	<span class="read_more">Leggi altro</span><br>
	</div>
	</div>
<?php
		endforeach;
	}?>

</div>
</div>
</div>
<div class="pushfooterB"></div>

<?php include('../UserRegistrato/includes/footer.php'); ?>

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
</html>