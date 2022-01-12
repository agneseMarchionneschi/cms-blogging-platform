
<?php include('../path.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../libs/database/config.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <!-- Font  -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<body>
<?php include('../UserRegistrato/includes/navbar.php') ?> 

<?php $userID = $_SESSION['user']['id']; //recupero l'ID dell'user dalla sessione ?>


    
    
<?php if (isset($_SESSION['user'])): ?>
        <div class="user-info">
          <h2 class="content-title">Benvenuto <span><?php echo  $_SESSION['user']['username'] ?></span> &nbsp; &nbsp; </h1>
        </div>
      <?php endif ?>
    <div class="container text-center">
      <div class="col-md-3">
        <a class="btn btn-primary btn-block" mb-3" href="createBlog.php" class="first"><span><i class="fas fa-plus"></i>Crea Blog</span> <br></a> </div>
      <div class="col-md-3">
        <a class="btn btn-primary btn-block" href="all_blogs.php"><span><i class="fas fa-plus"></i>Leggi Blog</span> <i class="fas fa-plus"></i><br></a></div>
      <div class="col-md-3">
        <a class="btn btn-primary btn-block" href="user.php"><span><i class="fas fa-plus"></i>Account</span> <br></a> </div>
  

  <?php $blogs = getMyblog($userID);//mostro i blog dell'user?>
    <br><h1 class="tuoiblog">I tuoi blog</h1>
<?php 
    if($blogs){ ?>
     <div class="row mb-2">
<?php
      foreach ($blogs as $blog): ?>
      <?php $imgID = $blog['image_id']; //imposto alcuni valori che mi servono ?>
      <?php $src = getImageByID($imgID)?>

  <div class="card" style="width: 18rem;">
    <img class="card-img-top" src="../assets/img/<?=$src?>"  alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title" id="tit"><?php echo $blog['title'] ?></h5>
    <p class="card-text" id="date"><span><?php echo date("j F, Y ", strtotime($blog["created_at"])); ?></span></p>
    <a href="all_post.php?blog_id=<?php echo $blog['id']; ?>"  id ="bon" class="btn btn-primary">Visualizza</a>
    <a href="gestisci_blog.php?blog_id=<?php echo $blog['id'];?>" id ="bon" class="btn btn-primary">Modifica</a>
   
  </div>
  </div>
    <?php endforeach ?>
<?php
    }else{ ?>
      <div class="pushfooter"></div>
<?php
    }?>    
      
  </div>  <br><br><br>     

</div>


</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php include('../UserRegistrato/includes/footer.php') ?> 
</html>

