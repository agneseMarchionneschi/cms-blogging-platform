<?php ob_start();?>
<?php include('../libs/database/db.php'); ?>
<?php include('../libs/database/config.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>
<?php $posts = getAllPosts(); 
$userID = $_SESSION['user']['id'];  
if (isset($_GET['post_id'])) {
	$post = getPost($_GET['post_id']);
	$postID = $post['id'];	
	$blogID = getblogIDbyPost($postID);
	$bID = $blogID['0'];
}
$post_id = [];
foreach($posts as $post){ //creo un array di ID per stabilire a quali posso accedere 
	array_push($post_id, $post['id']);
	//$blogID = getblogIDbyPost($postID);

	
}
//ciò è utile per garantire la sicurezza nella gestione dei blog
if (isset($_GET['post_id']) && in_array($_GET['post_id'], $post_id)) {
	$post = getPost($_GET['post_id']); //se è settato il post ID ed è nell'array creato sopra restituisco i post
        if(is_null($post)){ // se invece è nullo stampo che non ci sono post
            echo "non ci sono post";}
	}else{
	header('Location:../UserRegistrato/all_post.php');//altrimenti reindirizzo verso un'altra pagina 
	exit;
}
$comments = getPostComments($postID); //prendo i commenti del post con quell'id
$errors = array(); 

if (isset($_POST['action'])) { //action viene stabilito con un if dal value di un input
		$action = $_POST['action'];
		if ($action == 'like') { //se è settato like allora verrà aggiunto un like nel db
			addLike($userID, $postID);
		}
		elseif ($action == 'dislike') { //se è settato dislike allora verrà rimosso il like già inserito nel db
			removeLike($userID, $postID);
		}
}
	
if (isset($_POST['eliminaPost_btn'])){ //se viene premuto il tasto elimina post

 //Al click elimina a cascata tutto ciò che è connesso al post
	$querylike = "DELETE FROM likes WHERE post_id ='$postID'"; //se non ci sono like non cancellerà e passerà alla query successiva
    $resultlike = $conn->query($querylike); 
    if (!$resultlike) {
        echo "Errore nella query $querylike:".$conn->error;
    }else{ 
		$querycomme = "DELETE FROM comments WHERE post_id ='$postID'";
        $resultcomme = $conn->query($querycomme); 
        if (!$resultcomme) {
                echo "Errore nella query $querylike: ".$conn->error;
        }else{
            $query2 = "DELETE FROM posts WHERE id ='$postID'";
            $result2= $conn->query($query2); 
            if (!$result2) {
                echo "Errore nella query $query2:".$conn->error;
            }else{

				header('location: ../UserRegistrato/all_post.php?blog_id=' . $blogID[0]);
				 }
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

	
<body>


<?php include('../UserRegistrato/includes/navbar.php'); ?>
<?php $imgID = $post['image_id'] ;?>
<?php $src = getImageByID($imgID)?>
	<div class="page-wrlibser" >
	<h2 class="post-title"><?php echo $post['title']; ?></h2>
		<div class="full-post-div">
			<div class="post-body-div">
				<?php echo html_entity_decode($post['body']); ?><br><br>
        	</div>
			<div class="divFoto text-center">
				<img  class = "imgPostSingolo" src="../assets/img/<?=$src?>" >
			</div>
			<div id="btnsSPU">
			<?php $results = mysqli_query($conn, "SELECT * FROM posts WHERE user_id = $userID AND id= $postID"); 
            //controlla visibilità del bottone se l'utente ha scritto il post sarà visibile altrimenti no 
				
				if (mysqli_num_rows($results) == 1 ): ?>
           			<form id="fspec" class="elimpost" action="" method="POST">
	       				<input type="submit" class = "btn" name="eliminaPost_btn" id="bottonee" value="elimina post" >
           			</form>
				<?php endif; ?>



				<?php 
				$results = mysqli_query($conn, "SELECT * FROM posts WHERE user_id = $userID AND id= $postID"); 
				$result2 = mysqli_query($conn, "SELECT * FROM coautore WHERE blog_id= $bID AND user_id =$userID");
            //controlla visibilità del bottone se l'utente ha scritto il post sarà visibile altrimenti no 
				if (mysqli_num_rows($results) == 1 || mysqli_num_rows($result2) == 1  ):?>
					  
                    <a href="modifica_post.php?post_id=<?php echo $postID?>" id="btnL"><span id="bottonee">modifica post</span> <br></a>
                     
					   
				<?php endif; ?>
			</div>
		</div><br><br>

	






    	<div class="like" >
			<script>
			     function myFunction(x) {
			         x.classList.toggle("fa-thumbs-down");}
			</script>
        	<p><?php echo $numLike = contaLike($postID);?> likes</p>

			 <?php //stabilisce se l'user ha già messo like al post
				$results = mysqli_query($conn, "SELECT * FROM likes WHERE user_id = $userID AND post_id= $postID");

				if (mysqli_num_rows($results) == 1 ):?>

                    <form method="POST">
					 <!-- Pulsante "mi non piace" -->
                   		<button type="submit" onclick="myFunction(this)" class="fa fa-thumbs-down"></button>
                   		<input type="hidden" name="action" value="dislike">
                		<input type="hidden" name="postid" value="<?php echo $postID;?>">
                 	</form>

				<?php else:?>

					 <!-- Pulsante "mi piace" -->
                   	<form method="POST">
                   		<button type="submit"  onclick="myFunction(this)" class="fa fa-thumbs-up"></button>
                    	<input type="hidden" name="action" value="like">
                   	</form>
						
				<?php endif?>

    	</div>

<?php include "comment.php" ?>	
</script>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../assets/js/ricerca.js">  </script>
</html>
