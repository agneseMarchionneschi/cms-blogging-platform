<?php include('path.php'); ?>
<?php include('libs/database/db.php'); ?>
<?php include('libs/database/config.php'); ?>
<?php include('libs/includes/functions.php'); ?>

<?php 
$posts = getAllPosts(); 

//se è settata la variabile post_id carico i dati relativi a quel post
	if (isset($_GET['post_id'])) {
		$postID=$_GET['post_id'];
		$post = getPost($postID);
		$comments = getPostComments($postID);
		
	}

$post_id = [];
foreach($posts as $post){ //creo un array di ID per stabilire a quali posso accedere 
	array_push($post_id, $post['id']);
}

if (isset($_GET['post_id']) && in_array($_GET['post_id'], $post_id)) {
	$post = getPost($_GET['post_id']); //se è settato il blog ID ed è nell'array creato sopra restituisco i post
        if(is_null($post)){ //se è nullo 
            echo "non ci sono post";} //stampa che non ci sono post
}else{
	header('Location:'. BASE_URL. '/visualizzaPost.php');//altrimenti reindirizzo ad un'altra pagina
	exit;
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
  </head>
<body>
<?php include "includes/header.php" ?> 

<br><br>
<div class="content" >
     <?php $imgID = $post['image_id'] ;?>
	 <?php $src = getImageByID($imgID); //utilizzo questa a variabile per stampare il nome della foto nel percorso?>
	<div class="full-post-div">
			<h2 class="post-title"><?php echo $post['title']; ?></h2>
		<div class="post-body-div">
			<?php echo html_entity_decode($post['body']); ?><br><br>
        </div>
			<img  class = "singlepostImage"src="assets/img/<?php echo $src?>">
    </div><br><br><br>
              <p class="like"><?php echo $numLike = contaLike($postID); ?>   likes</p>

			
    </div>

</div>	

  <div class="comments">	
        <h2> Commenti </h2>
		<hr><br>	
         
	<?php foreach ($comments as $comment): //Mostro i commenti  ?>
	<div class="commSingolo">
		  <?php $commID = $comment['id']; ?>

	     <?php $commUserID = $comment['user_id']; ?>
         <div class="textcomment">
		  <?php $username = getUsernameByCommentuserID($postID,$commUserID); ?>
		   <h3>comment by:  <?php echo $username['0']?></h3><br>
		   <input readonly =" "class= "commenttxt" type="text" name="comment" value="<?php echo($comment['body']);?>" >
		  
			   <br><br>
			  
		   <span><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
		   
		 </div><br><br>
		  

		 
	</div>
	<?php endforeach ?>
    

 </div>

 
		
 <div class="pushfooter"></div>
</body>
<?php include('includes/footer.php') ?>
</html>