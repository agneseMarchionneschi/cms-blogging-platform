<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>


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
<?php include('../UserRegistrato/includes/navbar.php') ?>
<?php $userID = $_SESSION['user']['id'];

$blogs = getMyBlogPlusMeCoaut($userID);
$blogs_id = [];
foreach($blogs as $blog){
	array_push($blogs_id, $blog['id']);
}
//serve per garantire la sicurezza nella gestione dei blog
if (isset($_GET['blog_id']) && in_array($_GET['blog_id'], $blogs_id)) {
		$blogID = $_GET['blog_id'];//se è settato il blog ID ed è nell'array creato sopra restituisco i post
	
}else{
	header('Location:'. BASE_URL. '/UserRegistrato/dashboard.php'); //altrimenti ritorno alla dashboard
	exit;
}

include('includes/modificaBlog.php'); 


$bgs = getAllBg();
$headers = getAllHeader();


?>



<?php $blog =  getMyBlog($userID); ?>
<?php $src = getImageByblogID($blogID); ?>
<?php $coaut = getCoautbyBlogID($blogID); ?>

<?php $bg = getBackground($blogID); ?>
<?php $header = getHeader($blogID); ?>
<body>

    <h2 class="content-title">Modifica il layout</h2><br><hr><br>
    <div class ="page-wrlibser">
        <?php include('../UserRegistrato/includes/errors.php') ?>
            <br>
            <div class = "modimg text-center">

                <h2 class="content-titleL">Scegli sfondo</h2><br>
                
                    <form action="" method="post" >	
                        <input type="text" list="listasfondi" id="sfondi" autocomplete = "off" name="fileToUpload" placeholder="<?php if(isset($bg['0'])){echo $bg['0'];}else{ echo " ";} ?> " >
                        <datalist id="listasfondi">
                            <?php foreach ($bgs as $bg): // ciclo per far riempire la datalist con le varie opzioni?>
                                <?php $sfondo = $bg['src'];//assegno il nome del background a una variabile?>
                                <option value="<?php echo $sfondo ?>"> <?php echo $sfondo//stampa il valore dell'opzione?> </option>
    	                    <?php endforeach ?>
                        </datalist>
                        <input type="submit" class="btn btn-dark"value="Cambia sfondo" name="cambiasfondo">
                    </form>
          

                <br>
                <br>
                <br>

                <h2 class="content-titleL">Scegli Header</h2><br>
                
                    <form action="" method="post" >	
                        <input type="text" list="listaheaders" autocomplete = "off" id="headers" name="fileToUpload" placeholder="<?php echo $header ?> " >
                        <datalist id="listaheaders">
                            <?php foreach ($headers as $h): // ciclo per far riempire la datalist con le varie opzioni?>
                                <?php $headerName = $h['src'];//assegno il nome del header a una variabile?>
                                <option value="<?php echo $headerName ?>"> <?php echo $headerName //stampa il valore dell'opzione?> </option>
    	                    <?php endforeach ?>
                        </datalist>
                        <input type="submit" class="btn btn-dark"value="Cambia header" name="cambiaheader">
                    </form>
                
            </div>      
        </div>
        <br><br>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php include('../UserRegistrato/includes/footer.php') ?> 
</body> 
<script src="../assets/js/temi.js">  </script>
</html>