<?php include('../libs/database/config.php'); ?>
<?php include('../libs/database/db.php'); ?>
<?php include('../UserRegistrato/includes/userfunction.php'); ?>


<?php 
$userID = $_SESSION['user']['id'];
$users = getUsers($userID);


if (isset($_GET['blog_id'])) {  
    $blogID = $_GET['blog_id'];
    $blogs = getMyBlogPlusMeCoaut($userID);
    $blogs_id = [];
    foreach($blogs as $blog){
     array_push($blogs_id, $blog['id']);
    }
    //ciò è utile per garantire la sicurezza nella gestione dei blog
    if (isset($_GET['blog_id']) && in_array($_GET['blog_id'], $blogs_id)) {
      $blogID = $_GET['blog_id'];//se è settato il blog ID ed è nell'array creato sopra restituisco i post
    
    }else{
     header('Location:../UserRegistrato/dashboard.php');
     exit;
    }   
}

 
if (isset($_POST['nomina_btn'])){
	//controllo la stringa
    $string = esc($_POST['usernameCoaut']);
    if(empty($string)) { array_push($errors, "Inserisci l'username di chi vuoi rendere coautore");}
	if (preg_match('/[\'^£$%&*()}{@#~><>,|=_+¬]/', $string)){array_push($errors, "Caratteri non validi"); }
   
   
    if (count($errors) == 0) {
        $usercoaut = getUsersbyusername($string);//se non ci sono errori creo l'array usercoaut con tutti i dati dell'user coautore
        $coautID = $usercoaut['0'];
        if(!getUsersbyusername($string)); {array_push($errors, "Non è possibile nominare questo coautore"); }
    //eseguo controlli per differenziare l'user dal coautore
        if($userID == $coautID ){ 
            array_push($errors, "non puoi nominarti coautore");
        }else{
            $giaCoaut = "SELECT * FROM coautore WHERE blog_id = $blogID";
            $resultCheck = $conn->query($giaCoaut);
            mysqli_num_rows($resultCheck);
            if(mysqli_num_rows($resultCheck) > 0){ 
            	array_push($errors, "Coautore già nominato");}
            else{
            $query = "INSERT INTO coautore(blog_id,user_id) VALUES('$blogID', '$coautID')";
            $result = $conn->query($query);
            // controllo l'esito
            if (!$result) {
                 }
              else{ 
               $_SESSION['message'] = "coautore impostato con successo.";
               $_SESSION['type'] = 'success'; 
               header('location: ../UserRegistrato/gestisci_blog.php?blog_id='.$blogID);
               exit(0);  
             
              } 
            }
        }
     }        
}

if (isset($_POST['Rimuovinomina_btn'])){
    $string = esc($_POST['usernameCoaut']);
    if(empty($string)) { array_push($errors, "inserisci l'username di chi vuoi fare couatore del blog");}
	if (preg_match('/[\'^£$%&*()}{@#~><>,|=_+¬]/', $string)){array_push($errors, "characters are not valid"); }
   
    if (count($errors) == 0) {
        $usercoaut = getUsersbyusername($string);
        $coautID = $usercoaut['0'];
    
        if($userID == $coautID ){ 
            array_push($errors, "non puoi nominarti coautore");
        }else{
            $query = "DELETE FROM coautore WHERE user_id = $coautID AND blog_id ='$blogID'  ";
            $result = $conn->query($query);
            // controllo l'esito
            if (!$result) {
              echo "Errore nella query $query: " . $conn->error; 
                 }
              else{ 
               header('location: gestisci_blog.php?blog_id='.$blogID);
               exit(0);  
             
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


<title>Nomina coautore</title>
</head>
<body>

    <?php include('../UserRegistrato/includes/navbar.php') ?>
    <br>
	<div class="page-wrlibser">
        <h1 class="page-title">Scegli un coautore per il tuo blog</h1><br><br>

        <?php include('../UserRegistrato/includes/messages.php') ?>

        <div class="containerListsx">
            <div class="FormCercaCoaut text-center">
            		<h2>Cerca l'username di chi vuoi nominare coautore del tuo blog</h2><br>
            		<form method="post" action="coautore.php?blog_id=<?php echo $blogID?>">
                        <?php include('../UserRegistrato/includes/errors.php') ?>
                        <input class= "ricerca" type="text" name="usernameCoaut" autocomplete="off" placeholder ="Username" maxlength="30">
                        <button class="btn btn-dark" type="submit" name="nomina_btn">Nomina Coautore</button><br>
            		</form>
            		<form method="post" action="">
			    	<input class= "ricerca" type="text" name="usernameCoaut" autocomplete="off" placeholder ="<?php if(!empty($coaut)){echo $coaut['0'];}else{ echo"Nessun coautore";}?> "maxlength="30" >
			    	<button type="submit" class="btn btn-dark" name="Rimuovinomina_btn">Rimuovi Coautore</button>
				    </form>
            </div>
        </div>
    </div><br><br>
        <br><br><br><br><br>
        <br><br><br>


        <?php include('../UserRegistrato/includes/footer.php') ?>   
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../assets/js/ricerca.js">  </script>
</html>