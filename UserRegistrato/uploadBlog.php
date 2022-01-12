<?php
include('../libs/validation/validateBlog.php'); 
include('../UserRegistrato/includes/userfunction.php');


$table_1 = 'images';
$table_2 = 'blogs';
$target_dir = "/Applications/XAMPP/xamppfiles/htdocs/onblog/assets/img/" ;
$titolo ='';
$body ='';
$table = 'topics';
$rows=selectAll($table);
$topics=[];
foreach($rows as $row){
    $topics[$row['id']] = $row['nome'];//array contente tutti i topic presenti nel DB aventi come indice i loro id nella tabella.
}

$errors = array();

if(isset($_POST["submit"])) {

  $src = [];
  $blog = [];
  $img=[];
  $tema_blog=[];
  $tematica =[];
  $temi =[];


  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $img['tmp_name']=$_FILES["fileToUpload"]["tmp_name"];
  $img['size']=$_FILES["fileToUpload"]["size"];
  $img['imageFileType'] = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));  
  $img['target_file'] = $target_file;
  $blog['title'] = $_POST['titolo'];
  $src['src']= basename($_FILES["fileToUpload"]["name"]);
  $errors = validateBlog($img, $blog);
  
  if(isset($_POST['temi_list'])){
    $temi = $_POST['temi_list']; //array di temi ottenuti con metodo post dal form 
  }else{
    array_push($errors, 'Inserisci almeno un Tema per il Blog');
  } 
  if (count($errors) === 0) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $blog['slug'] = makeSlug($blog['title']);
      $blog['user_id'] = $_SESSION['user']['id'];
      $blog['image_id'] = create($table_1,$src);
      if(isset( $blog['image_id'])){
        $blog['id'] = create($table_2,$blog);
        
        if(isset($blog['id'])){

          $blogID = $blog['id'];
          foreach($temi as $tema){//per ogni elemento dell'array che contiene i temi 
            if(in_array($tema, $topics)){//controllo sulla presenza nell'array per 
              $tema_blog['tema_id'] = array_search($tema,$topics);//in caso positivo si ricava l'id del tema, nella tabella topics
              $tema_blog['blog_id'] = $blogID;
              $id_t_bl = create('temi_blog', $tema_blog);//crea la relativa istanza nella tabella tema_blog
            }else{// inserisce nella tabella topic il valore ottenuto da input
              $tematica['nome']= $tema;
              $tematica['slug'] = makeSlug($tematica['nome']);
              $id_tem = create($table, $tematica);//inserimento in topics
              if(isset($id_tem)){//se l'operazione è riuscita e quindi esiste un id per il nuovo topic creato
                $tema_blog['tema_id'] = $id_tem;
                $tema_blog['blog_id'] = $blogID;
                $id_t_bl = create('temi_blog', $tema_blog);//crea un istanza in temi_blog che mette in relazione l id del blog con quello del topic.
              }
            }
          }
          header('Location: http://localhost/onblog/UserRegistrato/gestisci_blog.php?blog_id=' . $blogID) ;
          
        }  
      } else {

        $_SESSION['message'] ="Mi dispiace, qualcosa non ha funzionato nella creazione del tuo Blog.";
        $_SESSION['type'] = 'error';
      }
    } else {

      $_SESSION['message'] ="Mi dispiace, qualcosa non ha funzionato nella creazione del tuo Blog.";
      $_SESSION['type'] = 'error';
    }

  }else{
    $titolo = $_POST['titolo'];
  }
// if everything is ok, try to upload file
}
?>