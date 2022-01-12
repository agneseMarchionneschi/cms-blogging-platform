<?php

require_once('config.php');

session_start();

//esegue la query serverdosi delle prepared statement
function executeQuery($sql, $data){
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
 //dati ottenuti
    $types = str_repeat('s', count($values));
 //array contente i tipi di valori che le values devono assumere per essere valide
    $stmt->bind_param($types, ...$values);//creano una lista/array delle values
 //ci si aspetterà un valore per ogni tipo e viceversa, rende più sicuro il processo
    $stmt->execute();
    return $stmt;
}

//restituisce un array contenente tutte le istanze di una tabella
//definisce inoltre che le condizioni di query sulla tabella sono un parametro della funzione opzionale
function selectAll($table, $conditions =  []){
    global $conn;//conessione al database
    $sql= "SELECT * FROM $table"; 
    if (empty($conditions)) {
        $stmt = $conn->prepare($sql);//prepara la query sql
        $stmt->execute();//esegue la stessa
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
 //fetch ritorna tutte	le	righe	come	un	array	in	un	
 //singolo	step.	Consuma più memoria	di	mysqli_fetch_array().
        return $records;
    } else {
        $i =0;
        foreach ($conditions as $key => $values) { // per ogni conditions=coppie di key e valori
            if ($i === 0){
                $sql = $sql . " WHERE $key=?";
 // per evitare sql injection si posiziona un placeholder e non i valori ottenuti dall'utente direttamente               
 //la sintassi delle query prevede un where iniziale alla prima richiesta
            } else {
                $sql = $sql . " AND $key=?";
 //dalla seconda richiesta si deve anteporre un And alla condizione
            }
            $i++;
        }
        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}

//restituisce un array contenente tutte le istanze di una tabella
 //definisce inoltre che le condizioni di query sulla tabella sono un parametro della funzione opzionale
function selectOR($table, $conditions =  []){

    global $conn;//conessione al database
    $sql= "SELECT * FROM $table"; 
    if (empty($conditions)) {
        $stmt = $conn->prepare($sql);//prepara la query sql
        $stmt->execute();//esegue la stessa
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
 //fetchritorna tutte	le	righe	come	un	array	in	un	
 //singolo	step.	Consuma più memoria	di	mysqli_fetch_array().
        return $records;
    } else {
        $i =0;
        foreach ($conditions as $key => $values) { // per ogni conditions=coppie di key e valori
            if ($i === 0){
                $sql = $sql . " WHERE $key=?";
 // per evitare sqlinjection si posiziona un placeholder e non i valori ottenuti dall'utente direttamente               
 //la sintassi delle query prevede un where iniziale alla prima richiesta
            } else {
                $sql = $sql . " OR $key=?";
 //dalla seconda richiesta si deve anteporre un And alla condizione
            }
            $i++;
        }
        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}

function selectOne($table, $conditions) {
    global $conn;
    $sql = "SELECT * FROM $table";

    $i=0;
    foreach ($conditions as $key => $values) {
        if ($i === 0){
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";
 //interessa solo il primo dato trovato, ferma il processo di scan dei dati una volta trovato 
    $stmt = executeQuery($sql, $conditions);
    $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    if(!empty($record)){
        return $record[0];
    }
}

//crea dei records da inserire nella tabella
function create($table, $data){
    global $conn;
    //$sql = "Insert Into user SET username=?, email=?, pass=?"
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $values) {
        if ($i === 0){
            $sql = $sql . "$key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id; //di norma ciò che interessa
    return $id;
}
//modifica dei records da inserire nella tabella
function update($table, $id, $data){
    global $conn;
    //$sql = "UPDATE $table SET username=?, email=?, pass=? WHERE $id=?(senza Where updata tutte le istanze della tabella"
    $sql = "UPDATE $table SET ";

    $i = 0;
    foreach ($data as $key => $values) {
        if ($i === 0){
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    $sql = $sql . " WHERE id=?";
    $data['id'] = $id; 
    //si allega il campo id,argomento della funzione, con relativo valore per matchare il numero di argomenti della sql
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
    //restituisce valori negativi se la query fallisce 
}
////elimina dei records da 
function delete($table, $id){
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";

    $stmt = executeQuery($sql, ['id' => $id]);//questa funzione riceve soltanto array associativi come parametro
    return $stmt->affected_rows;
    //restituisce valori negativi se la query fallisce 
    

}


?>