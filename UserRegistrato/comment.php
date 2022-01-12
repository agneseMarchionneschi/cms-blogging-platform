<?php 
$posts = getAllPosts(); 
$userID = $_SESSION['user']['id'];  
if (isset($_GET['post_id'])) { //se il post_id è settato
	$post = getPost($_GET['post_id']); //vengono dati i post con quell'id
	$postID = $post['id']; 
	
	$blogID = getblogIDbyPost($postID); //viene dato il blog che racchiude il post 
	$bID = $blogID['0'];
}
$post_id = [];
foreach($posts as $post){ //creo un array di ID per stabilire a quali posso accedere 
	array_push($post_id, $post['id']);
}
$comments = getPostComments($postID);	
$errors = array(); 


if (isset($_POST['commenta_btn'])) { //se viene premuto il tasto commenta
	$commento = esc($_POST['comment'],0,40); //ricevo in input la stringa e la controllo

	if (preg_match('/[\^£$&*}{@#~><>,|=_+¬]/', $commento)) //preg_match controlla che i caratteri siano validi
	  {array_push($errors, "Uno o più caratteri non validi"); } //se non lo sono viene restituito il seguente errore 
	if (empty($commento)) { array_push($errors, "Inserisci del testo"); } //se il commento è vuoto allora restituisce il seguente errore
	if (empty($errors)) {//se non ci sono errori inserisco nel db il commento e reindirizzo
	   	$sql = "INSERT INTO comments (user_id,post_id,body,created_at) VALUES('$userID','$postID','$commento',now())";
	   	$result = mysqli_query($conn, $sql);
	   	if (!$result) {
		   	echo "Errore nella query $query:".$conn->error; 
				}
		else{ 
			$_SESSION['user'] = getUserById($userID) ;
			header('location: open_post.php?post_id='.$postID );
			exit(0);
		} 
	} 
}
?>	


<div class="comments">	
    	    <h3 class="postScritte"> Scrivi un commento </h3>
			<br>
			<form method="post" action="open_post.php?post_id= <?php echo $postID?>" >
		
  			 <input class= "comment_txt" type="text" name="comment" value="" autocomplete = "off" maxlength="40">
			 <button class= "btn btn-dark"type="submit" class="btn" name="commenta_btn">Commenta</button><br>
			</form >
			<br><hr>	
		
		    <?php foreach ($comments as $comment):
		
		    //visualizzo tutti i commenti ?>
				<div class="commSingolo">
		     		<?php $commUserID = $comment['user_id']; ?>
		     		<?php $commID = $comment['id']; ?>
    	     		<div class="textcomment">
			  			<?php $username = getUsernameByCommentuserID($postID,$commUserID); ?>
			   			<h3 class="postScritte">Scrive:  <?php echo $username['0']?></h3><br>
						<input readonly =" "class= "commenttxt" type="text" name="comment" value="<?php echo($comment['body']);?>" >
						<br><br>
			   			<span><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
			   		</div>
    	       		<?php if($userID == $commUserID ): //l'utente vedrà il bottone per eliminare il commento se lui lo ha scritto?>
			   		<?php  include('deleteComment.php'); ?>
			   	<?php endif ?>
			<?php endforeach ?>
	</div>
	</div>	   
</div>	
<?php include('../UserRegistrato/includes/footer.php');?>
</body>