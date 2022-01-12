<!doctype html>
<html lang="en">
<?php  include('libs/database/config.php'); ?>
<?php  include('libs/database/db.php'); ?>
<?php
  require_once('visit.php'); 
  $page_id = 1; // la pagina ha un id=1 perchè in questo modo sapremo che nella tabella la pagina con questo id sarà visitata da un utente con un certo ip
  $visitor_ip = $_SERVER['REMOTE_ADDR']; // stores IP address of visitor in variable
  add_view($conn, $visitor_ip, $page_id);
  $total_page_views = total_views($conn, $page_id);
?> 
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Onblog - Create your blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
 <link href="includes/css/stile.css" rel="stylesheet" >
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
   
  </head>
  <body>
  <?php include "includes/header.php" ?> 

  <section id="hero" class="d-flex justify-content-center align-items-center">
      <div class="container position-relative aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
    		<h5 class="cre">CREA IL</br>IL TUO</br> BLOG</h5>
    		<p class="test1">Facile e veloce</br> inizia subito a creare </br> e condividere</p>

    </div>
  </section>


<div class="container">

  <div id="riga"class="row">
<div  class="col-sm">
  <div id ="about" class="card" style="width: 18rem;">
        <h4 id = "italic" class="fst-italic">Chi siamo</h4>
        <p id="it" class="mb-0">Una volta che ti sarai registrato potrai creare blog, post e permettere ad altri di modificare il tuo blog, divenendone il coautore. 
        Potrai inoltre libsortare modifiche stilistiche per rendere graficamente impeccabile il tuo blog.  Cosa aspetti? Corri a registrarti e comincia a pensare al tuo primo articolo! </p>
      </div> </div>
  	 <!-- card1 -->
    <div class="col-sm">
   <div id="ca" class="card" style="width: 18rem;">
  <img src="assets/css/img_css/4.png"  class="card-img-top" alt="create"> 
  <div class="card-body">
    <h5 class="card-title">Crea il tuo blog</h5>
    <p class="card-text">Registrati e inizia subito a raccontare le tue esperienze.</p>
    <a href="register.php" class="btn btn-primary">Registrati</a>
  </div>
  </div>
  </div>

 <!-- card2 -->
 <div class="col-sm">
  <div  id="ca" class="card" style="width: 18rem;">
  <img src="assets/css/img_css/2.jpeg"class="card-img-top12" alt="read">
  <div class="card-body">
    <h5 class="card-title">Leggi post</h5>
    <p class="card-text">Comincia a leggere i blog degli altri utenti e trova ispirazione per il tuo.</p>
    <a href="blog.php" class="btn btn-primary"> Guarda Blog</a>
  </div>
  </div>
  </div>

 <!-- card3 -->
 <div class="col-sm">
 <div  id="ca" class="card" style="width: 18rem;">
  <img src="assets/css/img_css/3.png"  class="card-img-top1" alt="...">
  <div class="card-body">
    <h5 class="card-title">Leggi post</h5>
    <p class="card-text">Leggi i post degli altri utenti che hanno deciso di raccontarsi.</p>
    <a href="post.php" class="btn btn-primary">Leggi Post</a>
  </div>
  </div>
   </div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

  <?php include "includes/footer.php" ?>   



</html>
