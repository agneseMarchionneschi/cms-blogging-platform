<?php
if (isset($_POST['eliminaComm_btn'])) { //cancella dai commenti e redirect
	$comm_id = $_POST['test'];
	//print_r($comm_id);
	$query="DELETE FROM comments Where id = '$comm_id'";
	$result = $conn->query($query);
	if (!$result) {
		echo "Errore nella query $query: " . $conn->error; 
	}else{ 
		$_SESSION['user'] = getUserById($userID) ;
		header('location: open_post.php?post_id='.$postID );
		exit(0);
	} 
	
} 
?>	     

<form class="elicomm" action="open_post.php?post_id= <?php echo $postID?>" method="POST">
							<?php $comment_id = $comment['id']; ?>
			  				<input type="hidden" name="test" value="<?php echo $comment_id?>">
			  				
		       <button type="submit" value="$comment_id" id="bottonee" class = "btnComm" name="eliminaComm_btn"> Cancella </button>
    	       			</form>