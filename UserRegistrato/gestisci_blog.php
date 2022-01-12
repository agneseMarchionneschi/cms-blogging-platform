<?php  include('../path.php'); ?>
<?php  include('../libs/database/config.php'); ?>
<?php  include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>



<?php
if (isset($_GET['blog_id'])) {
    $blogID = $_GET['blog_id'];
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

<title>User| Crea Blog</title>

</head>
<?php 
$userID = $_SESSION['user']['id']; //prendo gli id dell'user e del coautore
$coaut = getCoautbyBlogID($blogID);

if(empty($coaut)){  //se non ci sono coautori
    $blogs= getMyBlog($userID); //vedrò i blog dell'user
}else{
    $blogs = getMyBlogPlusMeCoaut($userID); //altrimenti vedrò i blogs dell'user più quelli dove è coautore
}


$blogs_id = [];
foreach($blogs as $blog){ //creo un array di ID per stabilire quali posso modificare e quali no
	array_push($blogs_id, $blog['id']);
}

//ciò è utile per garantire la sicurezza nella gestione dei blog
if (isset($_GET['blog_id']) && in_array($_GET['blog_id'], $blogs_id)) {
        $posts = getBlogPosts($_GET['blog_id']); //se è settato il blog ID ed è nell'array creato sopra restituisco i post
        if(is_null($posts)){ //se post è nullo allora stampo nessun blog 
            echo "Nessun Blog";}
}else{
	header('Location:../UserRegistrato/dashboard.php');//altrimenti reindirizzo verso la dashboard
	exit;
}



if (isset($_POST['eliminaBlog_btn'])){ //se viene premuto il tasto elimina blog
 //Elimina a cascata tutto ciò che riguarda il blog
    if(empty($posts)){

        $query0 = "DELETE FROM coautore WHERE blog_id ='$blogID'";
        $result0 = $conn->query($query0);
        if (!$result0) {
         echo "Errore nella query $query0: " . $conn->error; 
            }else{
                $queryP = "DELETE FROM customization WHERE blog_id ='$blogID'";
                $resultP = $conn->query($queryP);
                if (!$resultP) {
                    echo "Errore nella query $queryP: " . $conn->error; 
                    }else{ 
                       $query1 = "DELETE FROM blogs WHERE id ='$blogID'";
                       $result1 = $conn->query($query1);
                        // controllo l'esito
                       if (!$result1) {
                         echo "Errore nella query $query1: " . $conn->error; 
                       }else{   
                          header('location: ../UserRegistrato/my_blogs.php');
                          exit(0); }}
                }
    
    
    }else{
            foreach ($posts as $post){
            $postID = $post['id'];
        $queryC = "DELETE FROM coautore WHERE blog_id ='$blogID'";
        $resultC = $conn->query($queryC);
        if (!$resultC) {
         echo "Errore nella query $queryC: " . $conn->error; 
        }else{   
            $querylike = "DELETE FROM likes WHERE post_id ='$postID'";
            $resultlike = $conn->query($querylike); 
            if (!$resultlike) {
                echo "Errore nella query $querylike: " . $conn->error;
            }else{
                $querycomme = "DELETE FROM comments WHERE post_id ='$postID'";
                $resultlike = $conn->query($querylike); 
                if (!$resultlike) {
                    echo "Errore nella query $querylike: " . $conn->error;
                }else{
                    $query2 = "DELETE FROM posts WHERE id ='$postID'";
                    $result2= $conn->query($query2); 
                    if (!$result2) {
                            echo "Errore nella query $query2: " . $conn->error;
                    }else{
                        $queryP = "DELETE FROM customization WHERE blog_id ='$blogID'";
                        $resultP = $conn->query($queryP);
                        if (!$resultP) {
                            echo "Errore nella query $queryP: " . $conn->error; 
                        }else{ 
                           $query3 = "DELETE FROM blogs WHERE id ='$blogID'";
                           $result3= $conn->query($query3); 
                           if(!$result3) {
                            echo "Errore nella query $query3: " . $conn->error;
                           }else{
                            header('location: ../UserRegistrato/my_blogs.php');
                            exit(0);   
                         
                        }
                    }

                }
            }
                
        }
    }}
}}
        
    
?>
<script type="text/javascript">
function Conferma_eliminazione(){
	
	var domanda = confirm("Saranno cancellate tutte le informazioni sul blog, vuoi proseguire?");
	
	if (domanda==true){
		alert('cancellazione eseguita');
		return true;
	}
	else{
		alert('cancellazione non eseguita');
		return false;
	}
}
</script>


<body>
<?php include('includes/navbar.php') ?>	


<div class="page-wrapper">
    <?php include(ROOT_PATH . "/UserRegistrato/includes/messages.php") ?>

    <div class="containerCreateB text-center">
        <?php if (isset($_SESSION['user'])): ?>
    	    <div class="user-info">
                <h1><span><?php echo  $_SESSION['user']['username'] ?></span> il tuo blog:  &nbsp; &nbsp; </h1><h1 class="nomeBlog"><?php echo $title=getitleBlog($blogID); ?> </h1>
            </div>
        <?php endif ?> <br><br><br>
    
        <?php $src = getImageByblogID($blogID); ?>

        <?php $numPosts = countPosts($blogID); ?>
        <div class="containerInfo text-center">
        <p>Titolo:  <?php echo  $title=getitleBlog($blogID); ?><p>
        <p>Argomento:  <?php $topics = getBlogTopic($blogID); ?></p>
        <p>Immagine:  <?php echo $src['0'] ?> </p>
        <p>Coautore:  <?php if(!empty($coaut)){echo $coaut['0'];}else{ echo"Nessun coautore";}?> </p>
        <p>Numero di posts:  <?php echo $numPosts['0'] ?> </p><br>
        </div>
        <b>
        <form class="elimBlog" action="gestisci_blog.php?blog_id=<?php echo $blogID?>" method="POST" onsubmit="return Conferma_eliminazione()">
            <input type="submit" class = "btn btn-dark" name="eliminaBlog_btn" id = "<?php echo $blogID?>" name="invio" value="Elimina blog">
        </form>
        <br>
        <div class="stats">
            <a id="bottonee" href="creaPost.php?blog_id=<?php echo $blogID?>" class="first"><span>Crea un Post</span> <br></a>
            <a id="bottonee" href="coautore.php?blog_id=<?php echo $blogID?>" class="first"><span>Coautore </span> <br></a>
            <a id="bottonee"  href="modifica_blog.php?blog_id=<?php echo $blogID?>" class="first"><span>Modifica blog</span> <br></a>
        </div>
        <br>
        <hr>
        <div class="GestcontainerPost">
            <h1 class="nomeBlog">I tuoi post</h1>
            </div>
            <div class="row mb-2">
            <?php foreach ($posts as $post): ?>
                <?php $userID = $post['user_id']; ?>
            	<?php $imgID = $post['image_id'] ;?>
            	<?php $src = getImageByID($imgID)?>
                    <div class="card" style="width: 18rem;" >
                	<img  class = "card-img-top"src="../assets/img/<?=$src?>" alt="Card image cap">	
                    <h3><?php echo $post['title'] ?></h3>
                    <div class="Post_info">
                	    <p>Scritto da: <?php $username = getUsernameByPostUserID($userID) ; ?></p>
                	    <p><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></p> 
                	    <a href="open_post.php?post_id=<?php echo $post['id']; ?>"><span class="read_more">Leggi altro</span></a>
                	</div>
                    </div>
            
            <?php endforeach ?>
            
        </div>
      

    </div>
</div>
<?php include('includes/footer.php') ?>	
    
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
</html>