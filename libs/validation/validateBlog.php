<?php

//questa funzione sarà usata in uploadBlog per controllare che non ci siano errori
function validateBlog($img, $blog)
{
 
  $errors = array();
  
    
    if(empty($blog['title'])) { //se non viene inserito il titolo 
        array_push($errors, 'Inserisci il Titolo del Blog'); //restituisce l'errore 
    }
    
    $existingBlog = selectOne('blogs', ['title' => $blog['title']]); 
    //controlla se esiste già un blog con quel nome
    if (isset($existingBlog)) { //se è settato con un titolo già esistente
        array_push($errors, 'Titolo già in Uso'); //restituisce errore 
    }
    if(empty($img["tmp_name"])){ //se non viene inserita un'immagine per il blog 
        
      array_push($errors, "Inserisci un'immagine di copertina per il tuo post.");  //ritorna il seguente errore
      
     }else{
      
      //controlla se l'immagine è vera o un falso con la funzione getimagesize
      $check = getimagesize($img["tmp_name"]); 
      if($check == false) { //se il risultato è false 
          array_push($errors,  "File is not an image."); //restituisce il seguente errore
      }
    }

    // controlla che il file esista
    if (file_exists($img['target_file'])) { // se il file esiste 
      array_push($errors,  "Sorry, file already exists."); //restituisce il seguente errore
    
    }


    // controlla le dimensioni
    if ($img["size"] > 500000) { //se l'immagine supera la dimensione di 500000
      array_push($errors,  "Sorry, your file is too large."); //restituisce il seguente errore
    
    }

    // controlla i formati ammessi
    if($img['imageFileType'] != "jpg" && $img['imageFileType'] != "png" && $img['imageFileType'] != "jpeg"
    && $img['imageFileType'] != "gif" ) {
      array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    
    }

    return $errors;
}
?>
