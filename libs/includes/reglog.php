<?php

//inizializzo le variabili che ci danno le informazioni sull'utente
$username = "";
$email    = "";
$password = ""; 
$passwordConf = "";
$cellulare = "";
$documento = "";

$table ='users'; // inizializzo la tabella utente

$errors = array(); // inizializzo l'array con tutti gli errori

//rendo sicure le stringhe per fare si che i dati che inseriamo siano validi
function esc(String $value){
    
    global $conn;
    //la funzione trim rimuove gli spazi bianchi e altri caratteri da entrambi i lati di una stringa 
    $val = trim($value); 
    //funzione che per rendere sicuri i dati mette gli slash 
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}
//funzione che ci restituisce un array con i dati dell'utente
function getUserById($id){
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // ['id'=>1 'username' => 'jk', 'email'=>'a@a.com', 'password'=> 'mypass']
    return $user; 
}

// REGISTRAZIONE

if (isset($_POST['reg_btn'])) { // se il bottone registrati viene premuto ricevo in input i valori con il metodo post

    $datiUser = []; //creo l'array che conterrà i dati dell'utente

//inizio dei controlli per vedere se i dati sono validi
//controlli i caratteri 
        $username = esc($_POST['username'],0,15); // controllo che siano da 0 a 15 caratteri massimo
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) //controllo con preg_match() che non siano stati inseriti caratteri speciali
            {array_push($errors, "Caratteri in username non validi"); } //se non sono validi allora mando il messaggio di errore
        
        $datiUser['username'] = $username;  //se tutto va bene inserisco i valori nell'array datiUser  

        $email = esc($_POST['email'],0,15);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // filtra una variabile in base a dei criteri 
        if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $email))
            {array_push($errors, "Indirizzo mail non valido");}
    
        $datiUser['email'] = $email;  

        $password = esc($_POST['password'],0,15);
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))
            {array_push($errors, "Password non valida"); }

        $datiUser['password'] = password_hash($password, PASSWORD_DEFAULT); 

        $passwordConf = esc($_POST['passwordConf'],0,15);
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $passwordConf))
            { array_push($errors, "Password non valida");}
        
        
        $cellulare = esc($_POST['cellulare'],0,10);
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $cellulare))
            {array_push($errors, "Inserisci un numero di telefono valido");}
        
        $datiUser['cellulare'] = $cellulare;  

        $documento = esc($_POST['documento'],0,15);
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $documento))
            { array_push($errors, "Inserisci un numero di documento valido"); }

        $datiUser['documento'] = $documento; 

// controllo che siano stati riempiti correttamente tutti i campi

      if (empty($username)) { array_push($errors, "Campo username richiesto"); } //se il campo è vuoto restituisce errore 
      
      if (empty($email)) { array_push($errors, "Campo indirizzo mail richiesto"); }
    //filter_var() è un metodo che filtra una variabile con un filtro specifico
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {array_push($errors, "Email non valida");} //https://www.w3schools.com/php/php_form_url_email.asp
     
      if (empty($password)) { array_push($errors, "Password richiesta"); }
      if ($password != $passwordConf) {array_push($errors, "Le password non corrispondono");}

      if (empty($cellulare)) { array_push($errors, "Numero di telefono richiesto"); }
      if (!is_numeric($cellulare)) {array_push($errors, "Numero di telefono richiesto");}

      if (empty($documento)) { array_push($errors, "Documento richiesto"); }
      
//controllo che non ci siano utenti con gli stessi username ed email 

    $user_check_query = "SELECT * FROM users WHERE username='$username' 
                         OR email='$email' LIMIT 1";
    $usercheck = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($usercheck); // array associativo ovvero che associa ad un valore una stringa piuttosto che un valore

      if ($user) { 
        if ($user['username'] === $username) { 
            array_push($errors, "Username è già stato scelto");} //se esiste un username uguale allora restituisce errore
        if ($user['email'] === $email) {
            array_push($errors, "Questo indirizzo mail esiste già");}//se esiste una mail uguale allora resituisce errore
        }

//se non ci sono errori allora resetto i valori con unset
 if (count($errors) == 0) { 
     
    unset($_POST['reg_btn']); //unset dissocia i valori che ci sono stati fino a quel momento dalla variabile
    $datiUser['id'] = create($table,$datiUser);//creo l'utente
    $reg_userID = mysqli_insert_id($conn); // la funzione restituisce l'id autoincrement dell'utente registrato che gli ha dato mysqli
    //nell'array di sessione ci metto l'utente loggato e reindirizzo alla dashboard
    $_SESSION['user'] = getUserById($reg_userID); //SESSION è un array associativo che contiene tutte le variabili della sessione
    header('Location: ' . BASE_URL . '/UserRegistrato/dashboard.php');
    exit();
    }
}


// LOGIN 
if (isset($_POST['log_btn'])) { //se hai premuto accedi ricevi in input i valori con il metodo post

    $userLog = []; 
//inizio controlli per username e password 
//controllo con preg_match() che non siano stati inseriti caratteri speciali
    $username = esc(substr($_POST['username'],0,15)); //controllo che i caratteri siano minimo 0 e massimo 15
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))
        {array_push($errors, "Username non valido"); } //se è sbagliato invia errore

     $userLog['username'] = $username; //altrimenti se è giusto inserisco i valori nell'array con i dati dell'utente  

        $password = esc(substr($_POST['password'],0,15));
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password))
            {array_push($errors, "Password non valida"); }
  
    $userLog['password'] = $password;

//controllo che i campi non siano vuoti altrimenti invio gli errori 
    if (empty($username)) {array_push($errors, "Username richiesto");}
    if (empty($password)) {array_push($errors, "Password richiesta");}

    if (empty($errors)) { //se non ci sono errori
        //si utilizza una prepared statement essendo più sicura dato che si usano dati sensibili
        $log = selectOne($table, ['username' => $username ]); //selectOne prende tutti i dati di un determinato username dalla tabella 
        
        //se l'array non è null allora desetto i valori e inizio la sessione
        if ($log && password_verify($password, $log['password'] )) {  

            unset($_POST['log_btn']);
            $reg_userID = $log['id'];
            $_SESSION['user'] = getUserById($reg_userID); 
            //reindirizzo alla dashboard 
            header('location: ' . BASE_URL . '/UserRegistrato/dashboard.php');
            exit();
             
        } //altrimenti se i dati inseriti sono sbagliati invio errore
            else{
               array_push($errors, "Credenziali errate: inserisci il tuo username e la tua password");
            }
        } 
}


?>