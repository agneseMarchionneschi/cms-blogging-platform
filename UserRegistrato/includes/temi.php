<?php
include('../../path.php'); 
include(ROOT_PATH . '../libs/database/db.php'); 
include('userfunction.php'); 

$topics = [];
$topics = getTopicNames();

$topics = array_column($topics, "nome"); //per ogni topic(istanza di topics) s'inserisce l'attributo nome in una lista

$Jsontopics = json_encode($topics);//con il metodo json_encode si ottiene la rappresentazione in JSON di valori ottenuti tramite linguaggio php
echo($Jsontopics);

?>