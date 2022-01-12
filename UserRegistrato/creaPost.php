<?php  include('../path.php'); ?>
<?php  include('../libs/database/config.php'); ?>
<?php  include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet" type="text/css">
<!-- Font awesome -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- ckeditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<link rel="stylesheet" href="../wysiwyg/wysiwyg.css">
<title>User| Create Post</title>

</head>
<?php 
$userID = $_SESSION['user']['id'];

if (isset($_GET['blog_id'])) {
    $blogID = $_GET['blog_id'];
}
include('../UserRegistrato/uploadPost.php'); 

?>

<body onload="enableEditMode();">
<?php include('includes/navbar.php') ?> 
<?php include(ROOT_PATH . "/UserRegistrato/includes/messages.php") ?>
    <div class="page-wrlibser">
        <h1 id="PostH">Inizia la Creazione del tuo Post<span></span> &nbsp; &nbsp; </h1>
        <?php include('includes/errors.php') ?> 
        <div class="formCrea">
                <form name="myform" id="formCp"action="creaPost.php?blog_id= <?php echo $blogID ?>" method="post" enctype="multipart/form-data">    
                        
                    <label class="LICP">Inserisci il Titolo del tuo post</label></br>
                    <input type="text" id="titolo" name="titolo" value ="<?php echo $titolo ?>" maxlength="40" autocomplete="off"/> </br>                    
                    
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
                          <label class="LICP">Testo</label> </br>
                    <textarea style="display:none;" name="myTextArea" id="myTextArea" cols="100" rows="14"><?php echo($body)?></textarea>
                    <iframe name="richTextField" style="border:#000000 1px solid; width:470px; height:300px;"></iframe>
          
                    
                    <label class="LICP">Seleziona un'immagine per il tuo Post:</label> </br>
                    <input type="file" name="fileToUpload" id="fileToUpload"> </br></br>
                    <input class="btn" name="btn_Crea_Post" id="bottonee"type="button" value="CreaPost" onclick="javascript:submit_f(1);" />
                </form>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php include('../UserRegistrato/includes/footer.php') ?>   

</body>
<script src="../wysiwyg/wysiwyg.js"></script>
<script src="https://kit.fontawesome.com/6e8cae6392.js" crossorigin="anonymous"></script>

</html>