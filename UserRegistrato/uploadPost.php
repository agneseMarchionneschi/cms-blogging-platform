<?php
require_once('../path.php');
require_once('../libs/database/config.php');
require_once('../libs/database/db.php');
require('../libs/validation/validatePost.php'); 

if (isset($_GET['blog_id'])) {
  $blogID = $_GET['blog_id'];
}

//inizializzo le variabili
$table_1 = 'images';
$table_2 = 'posts';
$target_dir = "/Applications/XAMPP/xamppfiles/htdocs/onblog/assets/img/" ;
// !!!!!!!!!!!!!!!!!!!!!!! questa sul disco C?
$titolo = '';
$body = '';


if(isset($_POST["btn_Crea_Post"])) {

//inizializzo gli array per l'inserimento
  $src = [];
  $post = [];
  $img=[];
  //riempio l'array $img
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $img['tmp_name']=$_FILES["fileToUpload"]["tmp_name"];
  $img['size']=$_FILES["fileToUpload"]["size"];
  $img['imageFileType'] = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $img['target_file'] = $target_file;
  $src['src']= basename($_FILES["fileToUpload"]["name"]);;
  //riempio l'array post
  $post['title'] = $_POST['titolo'];
  $post['body'] = htmlentities($_POST['myTextArea']);
  
  $errors = validatePost($img, $post);//controllo che non ci siano errori 

  if (count($errors) === 0) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
 //riempio l'array post
      $post['slug'] = makeSlug($post['title']);
      $post['user_id'] = $_SESSION['user']['id'];
      $post['blog_id'] = $blogID; 
      $post['image_id'] = create($table_1,$src);//creo il record nella tabella images

      if(isset( $post['image_id'])){

        $post['id'] = create($table_2,$post); //creo il record nella tabella posts

        if(isset( $post['id'])){ //se ha avuto successo reindirizzo
          $_SESSION['message'] = "Il Post " . $post['title'] . " è stato creato con successo.";
          $_SESSION['type'] = 'success'; 
          header('Location: http://localhost/onblog/UserRegistrato/gestisci_blog.php?blog_id='.$blogID) ;
          exit();
        }  
      } else {//altrimenti segnalo l'errore

        $_SESSION['message'] ="Mi dispiace, qualcosa non ha funzionato nella creazione del tuo Post.";
        $_SESSION['type'] = 'error';
      }
    } else {

      $_SESSION['message'] ="Mi dispiace, qualcosa non ha funzionato nella creazione del tuo Post.";
      $_SESSION['type'] = 'error';
    }
  }else{
    $titolo = $_POST['titolo'];
    $body = $_POST['myTextArea'];//htmlentities
  
   
  }

}
?>