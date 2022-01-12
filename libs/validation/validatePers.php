<?php

function validateBlog($pers)
{
    
    $errors = array();
    
    if(empty($pers['temi_list[]'])) {
        array_push($errors, 'Inserisci almeno un Tema per il Blog');
    }
}

?>