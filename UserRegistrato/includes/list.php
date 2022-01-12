<?php
include('../../path.php'); 
include('../../libs/database/db.php'); 
include('userfunction.php'); 

if (isset($_GET['list'])){
    
    switch($_GET['list']){
        case "titlesU":
            $list = [];
            $list = getitleBlogs();
            
            
            $list = array_column($list,"title");
        break;
             
        case "topicsU":
            $list = [];
            $list = getTopicNames();
            
            $list = array_column($list, "nome");
        break;

        case "usernamesU":
            $list = [];
            $list = getUsersN();
            
            $list = array_column($list, "username");
        break;

        case  "titlesPU":
            if(isset($_GET['blog_id'])){
                $list = [];
                $list = getBlogPosts($_GET['blog_id']);

                $list = array_column($list, "title");
            }else{
                $list = [];
                $list = getAllPosts();
                
                $list = array_column($list, "title");
            }
        break;

        case "titles":
            $list = [];
            $list = getitleBlogs();
            
            $list = array_column($list,"title");
        break;

        case"topics":
            $list = [];
            $list = getTopicNames();
            
            $list = array_column($list, "nome");
        break;

        case"usernames":
            $list = [];
            $list = getUsersN();
            
            $list = array_column($list, "username");
        break;

        case "titlesP":
            $list = [];
            $list = getAllPosts();
            
            $list = array_column($list, "title");
        break;

    }
    
    $Jsonlist = json_encode($list);
    echo($Jsonlist); 
}
 //per ogni topic(istanza di topics) s'inserisce l'attributo nome in una lista
//
//;//con il metodo json_encode si ottiene la rappresentazione in JSON di valori ottenuti tramite linguaggio php
//

?>