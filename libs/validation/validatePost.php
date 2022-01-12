<?php


function validatePost($img, $post)
{
    
    $errors = array();

    
    if(empty($post['title'])) {

        array_push($errors, 'Inserisci il Titolo del Post.');

    }else{
        $existingPost = selectOne('posts', ['title' => $post['title']]);
        //controlla se esiste un post con quel titolo
        if (isset($existingPost)) {
            array_push($errors, 'Titolo già in Uso.');
        }
    }//controlla che non sia vuoto il body
    if(empty($post['body'])) {
        array_push($errors, 'Inserisci il Body del Post.');
    }
    //controlla che sia stata inserita l'immagine
    if(empty($img["tmp_name"])){
        array_push($errors, "Inserisci un'immagine di copertina per il tuo post.");
        
    }else{
        
        $check = getimagesize($img["tmp_name"]);
        if($check == false) {
            array_push($errors,  "File is not an image.");
        }
        // controlla se il file esiste già
        if (file_exists($img['target_file'])) {
          array_push($errors,  "Sorry, file already exists.");
        
        }
        // controlla la grandezza
        if ($img["size"] > 500000) {
          array_push($errors,  "Sorry, your file is too large.");
        
        }
        // controlla i formati
        if($img['imageFileType'] != "jpg" && $img['imageFileType'] != "png" && $img['imageFileType'] != "jpeg"
        && $img['imageFileType'] != "gif" ) {
          array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        
        }
    }
    return $errors;
}
?>