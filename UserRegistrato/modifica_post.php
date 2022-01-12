<?php ob_start();?>
<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../path.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>



<!DOCTYPE html>
<html>
<head>
<!-- Google Fonts -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet" type="text/css">
<!-- Font awesome -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- ckeditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<link rel="stylesheet" href="../wysiwyg/wysiwyg.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  

<script src="../wysiwyg/wysiwyg.js"></script>
<script src="https://kit.fontawesome.com/6e8cae6392.js" crossorigin="anonymous"></script>

</head>


<body onload="enableEditMode();">
<?php $userID = $_SESSION['user']['id'];



if (isset($userID)) { 
	$p_ids = [];
    $p_ids=getPidAutCoaut($userID);
    
}
//serve per garantire la sicurezza nella gestione dei blog
if(isset($_GET['post_id'])&& in_array($_GET['post_id'], $p_ids)){
    
    $post = getPost($_GET['post_id']); 
	$postID = $post['id'];	//se è settato il post_id ed è nell'array creato sopra restituisco i post
	
	$blogID = getblogIDbyPost($postID);
    $bID = $blogID['0'];
    
    $images = getAllImage();
    $src = getImageByPostID($postID);


}else{
	header('Location:../UserRegistrato/open_post.php?post_id='.$_GET['post_id']);//altrimenti reindirizzo verso un'altra pagina
	exit;
}
?>

	<?php include('../UserRegistrato/includes/navbar.php') ?>

	<div class="page-wrapper">
<?php include('../UserRegistrato/includes/errors.php') ?>
    <br>
		<h1 class="content-title">Modifica il  post</h1>
        <br>
		<hr><br>
        <h2 id="tij" class="content-title">Modifica titolo</h2>
		<br>
		<form id="sposta" method="post" action="">
			<input class= "ricerca" type="text" name="cambiaTitolo" autocomplete="off" placeholder ="<?php $title=getitlepost($postID); ?>" maxlength="30" >
			<button type="submit" id="bottonee" class="btn" name="ModCambiatitolo_btn">Cambia Titolo</button><br>
		</form>
        <br>
		<hr><br>
        <br>
        <h2 id="tij" class="content-title">Modifica body</h2>
        <div class="formCrea">
            <form name="myform" id="formCp" action="" method="post">					
                <div class="input-icons">
                    <div class="line">
                        <i class="fa fa-bold icon"></i>
                        <input type="button" class="input-field" title="bold"onclick="execCmd('bold');"/>
                        <i class="fa fa-italic icon"></i> 
                        <input type="button" class="input-field" title="italic"onclick="execCmd('italic');"/>
                        <i class="fa fa-underline icon"></i>
                        <input type="button" class="input-field" title="underline"onclick="execCmd('underline');"/>
                        <i class="fa fa-strikethrough icon"></i>
                        <input type="button" class="input-field" title="strikethrough"onclick="execCmd('strikeThrough');"/>
                        <i class="fa fa-align-left icon"></i>
                        <input type="button" class="input-field" title="align-left"onclick="execCmd('justifyLeft');"/>
                        <i class="fa fa-align-center icon"></i>  
                        <input type="button" class="input-field" title="align-center"onclick="execCmd('justifyCenter');"/>
                        <i class="fa fa-align-right icon"></i>  
                        <input type="button" class="input-field" title="align-right"onclick="execCmd('justifyRight');"/>
                        <i class="fa fa-align-justify icon"></i> 
                        <input type="button" class="input-field" title="justify"onclick="execCmd('justifyFull');"/>
                        <i class="fa fa-cut icon"></i>   
                        <input type="button" class="input-field" title="cut"onclick="execCmd('cut');"/>
                        <i class="fa fa-copy icon"></i>
                        <input type="button" class="input-field" title="copy"onclick="execCmd('copy');"/>
                        <i class="fa fa-indent icon"></i>
                        <input type="button" class="input-field" title="indent"onclick="execCmd('indent');"/>
                        <i class="fa fa-dedent icon"></i>
                        <input type="button" class="input-field" title="outdent"onclick="execCmd('outdent');"/>
                        <i class="fa fa-subscript icon"></i> 
                        <input type="button" class="input-field" title="subscript"onclick="execCmd('subscript');"/>
                        <i class="fa fa-superscript icon"></i>
                        <input type="button" class="input-field" title="superscript"onclick="execCmd('superscript');"/>
                        <i class="fa fa-undo icon"></i> 
                        <input type="button" class="input-field" title="undo"onclick="execCmd('undo');"/>
                        <i class="fa fa-redo icon"></i>
                        <input type="button" class="input-field" title="redo"onclick="execCmd('redo');"/>
                        <i class="fa fa-list-ul icon"></i>
                        <input type="button" class="input-field" title="unordered-list"onclick="execCmd('insertUnorderedList');"/>
                        <i class="fa fa-list-ol icon"></i>
                        <input type="button" class="input-field" title="ordered-list"onclick="execCmd('insertOrderedList');"/>
                        <i class="fa fa-paragraph icon"></i>
                        <input type="button" class="input-field" title="paragraph"onclick="execCmd('insertParagraph');"/>
                        <i class="icon">H </i>  
                        <input type="button" class="input-field" title="horizontal-rule"onclick="execCmd('insertHorizontalRule');"/>
                        <i class="fa fa-link icon"></i> 
                        <input type="button" class="input-field" title="link"onclick="execCommandwithArg('createLink', prompt('Inserisci un URL', 'http:' ));"/>
                        <i class="fa fa-unlink icon"></i>
                        <input type ="button" class="input-field" title="unlink"onclick="execCmd('unlink');"/>


                    </div>
                    <div id="line2">
                        <select title="title"id="tendina"onclick="iHead('format', this.value);">
                            <option value="H1">H1</option>
                            <option value="H2">H2</option>
                            <option value="H3">H3</option>
                            <option value="H4">H4</option>
                            <option value="H5">H5</option>
                            <option value="H6">H6</option>
                        </select>

                        <select title="Font"onclick="execCommandwithArg('fontName', this.value);">
                            <option value='Arial'>Arial</option>
                            <option value='ComicSansMS'>Comic Sans MS</option>
                            <option value='Courier'>Courier</option>
                            <option value='Georgia'>Georgia</option>
                            <option value='Tahoma'>Tahoma</option>
                            <option value='TimesNewRoman'>Times New Roman</option>
                            <option value='Verdana'>Verdana</option>
                        </select>

                        <select title="font-size" onclick="execCommandwithArg('fontSize', this.value);">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                        <!--Migliorare scelta colori -->
                        Fore Color:  <input type="color" onclick="execCommandwithArg('foreColor', this.value);" style="width:20px;"/> 
                        Background:  <input type="color" onclick="execCommandwithArg('hiliteColor', this.value);" style="width:20px;"/>
                    </div>
                </div>
                <textarea style="display:none;" name="myTextArea" id="myTextArea" cols="100" rows="14"><?php echo($body=getbodypost($postID))?></textarea>
                <iframe name="richTextField" style="border:#000000 1px solid; width:470px; height:300px;"></iframe>
              
                <input type="submit" class="btn" name="btn_Mod_Post" id="bottonee" type="button" value="CreaPost" onclick="javascript:submit_f(2);" />
            </form>
		</div>
		<br><br>
		<hr><br><br>


		<h2 id="tij" class="content-title">Scegli tra le immagini</h2>
    <div id="sposta1" class="formCambia">
     <form action="" method="post" >	
     <input type="text" list="listaimmagini" id="immagini" autocomplete = "off" name="fileToUpload" placeholder=" <?php echo $src['0'] ?>" >
     <datalist id="listaimmagini">
     <?php foreach ($images  as $img): // questo ciclo è utilizzato per far riempire la datalist con le varie opzioni?>
        <?php $imgName  = $img['src'];//assegno il nome dell'immagine a una variabile?>
        <option value="<?php echo $imgName  ?>"> <?php echo $imgName ?> </option>
	 <?php endforeach ?>
     </datalist>

     <input type="submit" class="btn"value="Cambia" id="bottonee" name="cambiaimg">
     </form>
 </div>






	</div>
	
	<?php include('../UserRegistrato/includes/footer.php'); ?>

</body>

</html>
<script src="../wysiwyg/wysiwyg.js"></script>

<?php

//TITOLO
if (isset($_POST['ModCambiatitolo_btn'])){

    $title = esc($_POST['cambiaTitolo']);//controllo che non ci siano errori nella stringa 

    if (empty($title)) { array_push($errors, "inserisci un titolo");}
    if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $title)){
            array_push($errors, "caratteri non validi"); }
    
      
 if (empty($errors)) {

    $post_check_query = "SELECT * FROM posts where title = '$title' LIMIT 1";
    $postcheck = mysqli_query($conn, $post_check_query);
    
    $post = mysqli_fetch_assoc($postcheck);
    if (!$post) { 
        $query = "UPDATE posts SET title = '$title' WHERE id = $postID";
        $result = $conn->query($query);
        if (!$result) {
        echo "Errore nella query $query: " . $conn->error; }
        else{ 
            
           header('Location: open_post.php?post_id='.$postID);
           exit();}
    
       }else {array_push($errors, "titolo già in uso");}
} }
//CORPO TESTUALE
if (isset($_POST['btn_Mod_Post'])){
    
    $corpoT = htmlentities($_POST['myTextArea']);
    $corpoT = esc($corpoT);//controllo che non ci siano errori nella stringa 

    if (empty($corpoT)) { array_push($errors, "inserisci Corpo testuale del Post");}

    if (empty($errors)) {
        $post_check_query = "SELECT * FROM posts where body = '$corpoT' LIMIT 1";
    $postcheck = mysqli_query($conn, $post_check_query);
    
    $post = mysqli_fetch_assoc($postcheck);
    if (!$post) 
        $query = "UPDATE posts SET body = '$corpoT' WHERE id = $postID";
        $result = $conn->query($query);
        if (!$result) {
            echo "Errore nella query $query: " . $conn->error; 
        }else{ 
           
            header('Location: open_post.php?post_id='.$postID) ;
            exit();
        }
    }
} 

//IMMAGINI 
if(isset($_POST["cambiaimg"])) {
    $src = esc($_POST['fileToUpload']);
    if(empty($src)) { 
        array_push($errors, "inserisci il nome.formato dell'immagine");
       }
   
       $query = "SELECT src from images WHERE src= '$src'";
       $result = $conn->query($query);
      
       if (!$result ||mysqli_num_rows($result) == 0) {
          array_push($errors, "immagine non disponibile");
        }
     
	
	if(count($errors)==0){ 
	$imgID= getImageBySRC($src);
	$id = $imgID['0'];
    $query = "UPDATE posts SET image_id = $id WHERE id=$postID";
    $result = $conn->query($query);
    // controllo l'esito
    if (!$result) {
         echo "Errore nella query $query: " . $conn->error;  }
	else{ 
      
       header('Location: open_post.php?post_id='.$postID);
       exit();  
     
      } 
  }
} 
?>