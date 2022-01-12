<?php

//TOPICS---------

//inizializzo le variabili per creare il topic
$table = 'topics';
$table2 = "temi_blog";
$rows=selectAll($table);//ottengo un array multidimensionale in cui ogni array è un'istanza della tabella topics
$data['blog_id']=$blogID;
$b_ts = selectAll($table2,$data);//ottengo un array multidim in cui ogni istanza, della tabella temi_blog, ottenuta ha come attributo blog_id l'id ottenuto tramite il metodo GET nella pagina changeBlog
$blog_topics =[];
$b_TID = [];


foreach($b_ts as $b_t){//esegue un ciclo sull'array contenente le associazioni topic/blog
    array_push($blog_topics,$b_t['tema_id']);//in blog_topics vengono progressivamente aggiunti(tramite il metodo array_push) gli id dei topic associati al blog selezionato in precedenza
    $b_TID[$b_t['id']]=$b_t['tema_id'];// nell'array b_TID viene inizalizzato come indice l'id dell'istanza della tabella temi_blog e come valore l'id della tematica
}

$topics=[];

foreach($rows as $row){
    $topics[$row['id']] = $row['nome'];//inzializzo un array multidimensionale in cui gli indici sono gli id delle istanze della tabella topics e i valori sono ottenuti dall'attributo nome della stessa tabella
}

if(isset($_POST['mod_tm'])){
    
    $tema_blog=[];
    $tematica =[];
     
    unset($_POST['crea_tm']);

    $temi = $_POST['temi_list'];//temi_list è l'array contenente i topic selezionati al momento che si è premuto il bottone submit


    $i = 0;
    $cT = count($temi);

    foreach($temi as $tema){//per ogni topic passato dall'utente
        if(in_array($tema, $topics)){//viene eseguito un controllo sulla sua presenza nella tabella topics
            $tema_blog['tema_id'] = array_search($tema,$topics);//se presente si procede alla creazione di un array contenente gli attributi necessari alla creazione di una nuova istanza sulla tabella temi_blog
            if(in_array($tema_blog['tema_id'],$blog_topics)){//viene eseguito un ulteriore controllo per accertare che l'istanza in questione non sia già presente sul db.
                $i = $i +1;
                unset($blog_topics[array_search($tema_blog['tema_id'],$blog_topics)]);//se è già presente unèistanza con attributi tema_id e blog_id uguali allora quello appena passato viene eliminato dai topic da controllare
            }else{//se invece non esiste ancora una relazione fra il blog e il topic in questione
                $tema_blog['blog_id'] = $blogID;
                $id_t_bl = create('temi_blog', $tema_blog);
                if(isset($id_t_bl)){
                   $i = $i +1;
                }
            }
        }else{ // se il topic è assente dalla tabella topics
            $tematica['nome']= $tema;
            $tematica['slug'] = makeSlug($tematica['nome']);
            $id_tem = create($table, $tematica);//viene creato con gli attributi ottenuti dall'utente
            if(isset($id_tem)){
                $tema_blog['tema_id'] = $id_tem;
                $tema_blog['blog_id'] = $blogID;
                $id_t_bl = create('temi_blog', $tema_blog);// e successivamente associato al blog
                if(isset($id_t_bl)){
                    $i = $i +1;
                }
            }else{
                array_push($errors, 'Fallimento a Creare la nuova Tematica');
            }
        }
       
    }
    $count = 0;
    foreach($blog_topics as $blog_topic){// i blog che erano stati associati in un primo momento al blog ma che l'utente ha ritenuto oppurtono non reinserire nella modifica vengono eliminati
        $b_T = array_search($blog_topic, $b_TID);
        if(isset($b_T)){
            delete($table2, $b_T);
            unset($blog_topics[$count]);
            $count ++; 
        }
    
    }
    
    if ($i === $cT && empty($blog_topics)){//doppio controllo sulla fine dei controlli sull'array dei temi ottenuti dal form compilato dall'utente
        //reindirizzamenti in casi di successo o insuccesso
        
        $_SESSION['message'] = "Le modifiche sono state compiute con successo.";
        $_SESSION['type'] = 'success'; 
        header('Location: gestisci_blog.php?blog_id='.$blogID) ;
        exit();
    }else{
        
        $_SESSION['message'] = "Le modifiche NON sono state compiute con successo.";
        $_SESSION['type'] = 'error'; 
        header('Location: gestisci_blog.php?blog_id='.$blogID) ;
        exit();
    }
}




//TITOLO
if (isset($_POST['ModCambiatitolo_btn'])){

    $title = esc($_POST['cambiaTitolo']);//controllo che non ci siano errori nella stringa 

    if (empty($title)) { array_push($errors, "inserisci un titolo");}
    if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $title)){
            array_push($errors, "caratteri non validi"); }
    
      
 if (empty($errors)) {

    
    $blog_check_query = "SELECT * FROM blogs where title = '$title' LIMIT 1";
    $blogcheck = mysqli_query($conn, $blog_check_query);
    
    $blog = mysqli_fetch_assoc($blogcheck);
    if (!$blog) { 
        $titleslug = makeSlug($title);
        $query = "UPDATE blogs SET title = '$title', slug = '$titleslug' WHERE id = $blogID";
        $result = $conn->query($query);
        if (!$result) {
        echo "Errore nella query $query: " . $conn->error; }
        else{ 
           header('location: gestisci_blog.php?blog_id='.$blogID);
           exit(0);}
    
       }else {array_push($errors, "titolo già in uso");}
} }
//COAUTORE 
if (isset($_POST['Modnomina_btn'])){
    $string = esc($_POST['usernameCoaut']);
    if(empty($string)) { array_push($errors, "inserisci l'username di chi vuoi fare couatore del blog");}
	if (preg_match('/[\'^£$%&*()}{@#~><>,|=_+¬]/', $string)){array_push($errors, "characters are not valid"); }
   
    if (count($errors) == 0) {
        $usercoaut = getUsersbyusername($string);
        $coautID = $usercoaut['0'];
    
        if($userID == $coautID ){ 
            array_push($errors, "non puoi nominarti coautore");
        }else{
            $query = "UPDATE coautore SET user_id = '$coautID'";
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
    $query = "UPDATE blogs SET image_id = $id WHERE id=$blogID";
    $result = $conn->query($query);
    // controllo l'esito
    if (!$result) {
         echo "Errore nella query $query: " . $conn->error;  }
	else{ 
       header('location: gestisci_blog.php?blog_id='.$blogID);
       exit(0);  
     
      } 
  }
} 


if(isset($_POST["cambiasfondo"])) {
    $src = esc($_POST['fileToUpload']);
 
   if(empty($src)) { 
     array_push($errors, "inserisci il nome.formato dell'immagine");
    }

    $query = "SELECT src from backgrounds WHERE src= '$src'";
    $result = $conn->query($query);
   
    if (mysqli_num_rows($result) == 0) {
       array_push($errors, "sfondo non disponibile, scegli tra quelli proposti");
     }
     

	if(count($errors)==0){
	$bgID= getBGBySRC($src);
    $id = $bgID['0'];
    $checkquery = "SELECT * FROM customization WHERE blog_id=$blogID";
    $checkresult = $conn->query($checkquery);
    if(!$checkresult || mysqli_num_rows($checkresult) == 0){
        $queryinsert="INSERT INTO customization(blog_id,sfondo_id,header_id) values($blogID,$id,NULL)";
        $resultinsert = $conn->query($queryinsert);
        if (!$result) {
            echo "Errore nella query $queryinsert: " . $conn->error;  }
        else{ 
          header('location: all_post.php?blog_id='.$blogID);
          exit(0);  
        
         } 
    }else{
        $query = "UPDATE customization SET sfondo_id = $id WHERE blog_id=$blogID";
        $result = $conn->query($query);
        // controllo l'esito
        if (!$result) {
         echo "Errore nella query $query: " . $conn->error;  }
	    else{ 
           header('location: all_post.php?blog_id='.$blogID);
           exit(0);   } }  
  }
} 

if(isset($_POST["cambiaheader"])) {
    $src = esc($_POST['fileToUpload']);
 
   if(empty($src)) { 
     array_push($errors, "inserisci il nome.formato dell'immagine");
    }
    
    $query = "SELECT src from header WHERE src= '$src'";
    $result = $conn->query($query);
    
 
    if (mysqli_num_rows($result) == 0) {
       array_push($errors, "header non disponibile, scegli tra quelli proposti");
     }
	
	if(count($errors)==0){
	$headerID= getHeaderBySRC($src);
    $Hid = $headerID['0'];
    $Hcheckquery = "SELECT * FROM customization WHERE blog_id=$blogID";
    $Hcheckresult = $conn->query($Hcheckquery);

    if(!$Hcheckresult || mysqli_num_rows($Hcheckresult) == 0){
        $Hqueryinsert="INSERT INTO customization(blog_id,sfondo_id,header_id) values($blogID,NULL,$Hid)";
        $Hresultinsert = $conn->query($Hqueryinsert);
        if (!$Hresultinsert) {
            echo "Errore nella query $Hqueryinsert: " . $conn->error;  }
        else{ 
          header('location: all_post.php?blog_id='.$blogID);
          exit(0);  
        
         } 
    }else{
    $query = "UPDATE customization SET header_id = $Hid WHERE blog_id=$blogID";
    $result = $conn->query($query);
    // controllo l'esito
    if (!$result) {
         echo "Errore nella query $query: " . $conn->error;  }
	else{ 
       header('location:  all_post.php?blog_id='.$blogID);
       exit(0);  } } 
  }
} 
?>