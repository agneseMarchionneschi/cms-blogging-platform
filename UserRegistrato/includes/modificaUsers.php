<?php 
//inizializzo le variabili
$userID = $_SESSION['user']['id'];
$newusername = "";
$newemail    = "";
$newpassword = ""; 
$haspas = "";
$newcellulare = "";
$newdocumento = "";





$errors = array(); 

if (isset($_POST['modifica_btn'])) {
 //controllo le stringhe in input
 $newusername = esc($_POST['username']);
 if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $newusername))
    {array_push($errors, "Username's characters are not valid"); }

 $newemail = esc($_POST['email']);
 $newemail = filter_var($newemail, FILTER_SANITIZE_EMAIL);
 if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $newemail))
    {array_push($errors, " email's characters are not valid");}

 $newpassword = esc($_POST['password']);
 if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $newpassword))
    {array_push($errors, "password's characters are not valid"); }

 $newcellulare = esc($_POST['cellulare']);
 if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $newcellulare))
    {array_push($errors, "password's characters are not valid");}

 $newdocumento = esc($_POST['documento']);
 if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $newdocumento))
    { array_push($errors, " characters are not valid"); }

 // controllo che siano stati riempiti correttamente tutti i campi
 if (empty($newusername)) { array_push($errors, "Username is required"); }
 if (empty($newemail)) { array_push($errors, "Email is required"); }
 //filter_var() è un metodo che filtra una variabile con un filtro specifico
 if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {array_push($errors, "Email is not valid");} //https://www.w3schools.com/php/php_form_url_email.asp
 if (empty($newpassword)) { array_push($errors, "Password is required"); }
 if (empty($newcellulare)) { array_push($errors, "phone is required"); }
 if (!is_numeric($newcellulare)) {array_push($errors, "phone is not valid");}
 if (empty($newdocumento)) { array_push($errors, "document is required"); }

 //controllo che non ci sia un utente con la solita mail o username
 $user_check_query = "SELECT * FROM users WHERE username='$newusername' 
                 OR email='$newemail' LIMIT 1";
 $usercheck = mysqli_query($conn, $user_check_query);
 $user = mysqli_fetch_assoc($usercheck);

 if ($user) { 
 if ($user['username'] === $newusername && $user['id'] != $userID ) {
  array_push($errors, "Username already exists");}
 if ($user['email'] === $newemail && $user['id'] != $userID) {
  array_push($errors, "Email already exists");}
 }

 if (empty($errors)) {
  $haspas= password_hash($newpassword, PASSWORD_DEFAULT);
 $query = "UPDATE users SET username = '$newusername', email = '$newemail', password = '$haspas', cellulare = '$newcellulare',  documento = '$newdocumento' WHERE id = $userID";
 $result = $conn->query($query);

 // controllo l'esito
 if (!$result) {
  
 echo "Errore nella query $query: " . $conn->error; 
   }

  else{ 

    // prendo l'id dell'utente registrato grazie al metodo insert_id()
    $reg_user_id = mysqli_insert_id($conn);
    // metto l'utente loggato nel'array di sessione
    $_SESSION['user'] = getUserById($reg_user_id);
    header('location: ../login.php');
    exit(0);}
 }
}

if (isset($_POST['cancella_btn'])) {
   //controllo l'input
    $delpassword = esc($_POST['password']);
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $delpassword))
       {array_push($errors, "password's characters are not valid"); }
   
    if (empty($delpassword)) { array_push($errors, "Password is required"); }
    
   if (empty($errors)) {
    //cancello a cascata tutto ciò che ha fatto l'utente
      $blogs=getMyBlog($userID);
      $query1 = "DELETE FROM comments WHERE user_id ='$userID'";
      $result1 = $conn->query($query1);
      if (!$result1) {
        echo "Errore nella query $query1: " . $conn->error; 
      }else{
              $query2 = "DELETE FROM likes WHERE user_id ='$userID'";
              $result2 = $conn->query($query2);
              if (!$result2) {
              echo "Errore nella query $query2: " . $conn->error; 

         }else{  
           $query3 = "DELETE FROM posts WHERE user_id ='$userID'";
           $result3 = $conn->query($query3);
            if (!$result3) {
                 echo "Errore nella query $query3: " . $conn->error; 

            }else{
               //blocco temi 
               if(!is_null($blogs)){
                     foreach ($blogs as $blog){
                         $blogID = $blog['id'];
                         $querytemi = "DELETE FROM temi_blog WHERE blog_id ='$blogID'";
                         $resulttemi = $conn->query($querytemi); }
                     if (!$resulttemi) {
                          echo "Errore nella query $querytemi: " . $conn->error; 
                     }else{
                           $query = "DELETE FROM blogs WHERE user_id ='$userID'";
                           $result = $conn->query($query);
                           }}
               //---------------------------------------
               $query4 = "DELETE FROM blogs WHERE user_id ='$userID'";
               $result4 = $conn->query($query4);
                // controllo l'esito
                if (!$result4) {
                 echo "Errore nella query $query2: " . $conn->error; 
                }else{   
                   $finalquery = "DELETE FROM users WHERE id ='$userID'";
                    $finalresult = $conn->query($finalquery);
                    // controllo l'esito
                   if (!$finalresult) {
                   echo "Errore nella query $finalquery: " . $conn->error; 
                   }else{ 
                         header('location: ../index.php');
                         exit(0);   
                      }
                  }
               }
            }  
         }
     }
}  


?>