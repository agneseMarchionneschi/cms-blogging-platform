<?php include('path.php'); ?>
<?php include('libs/database/db.php'); ?>
<?php include('libs/includes/reglog.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Onblog - Crea il tuo blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="includes/css/stile.css" rel="stylesheet" >
  </head>
 <body>
  <?php include "includes/header.php" ?> 
  
<body class="logg">

 


<form action="register.php" method ="post">
     
     <?php include('libs/includes/errors.php'); //GESTIONE DEGLI ERRORI?>

     <div class="container mt-5 mb-5">
     <div class="row d-flex align-items-center justify-content-center">
          <div class="col-md-6">
               <div class="cardreg"> <span class="circle"><i class="fa fa-check"></i></span>
                    <h5 class="mt-3">UNISCITI </h5>  </br>
                    
                    <div class="form-input"> 
                         <label for="exampleFormControlInput1" class="form-label" >Username</label>
                         <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" maxlength="20" autocomplete = "off"/>
                    </div> </br>
         
                    <div class="form-input"> 
                         <label for="exampleFormControlInput1" class="form-label">Email</label>
                         <input type="text" class="form-control"  name="email"  value="<?php echo $email; ?>"maxlength="30" autocomplete = "off"/>  
                    </div> </br>
                    
                    <div class="form-input">
                         <label for="exampleFormControlInput1" class="form-label">Password</label>
                         <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" maxlength="15" autocomplete = "off"/> 
                    </div></br>
                    
                    <div class="form-input">
                         <label for="exampleFormControlInput1" class="form-label">Conferma Password</label>
                         <input type="password" class="form-control" name="passwordConf"  maxlength="15" autocomplete = "off"/> 
                    </div></br>
                    
                    <div class="form-input">
                         <label for="exampleFormControlInput1" class="form-label">Numero di telefono</label>
                         <input type="text"  class="form-control" name="cellulare" value="<?php echo $cellulare; ?>" maxlength="15" autocomplete = "off"/> 
                    </div></br>
    
                    <div class="form-input">
                         <label for="exampleFormControlInput1" class="form-label">Numero documento</label>
                         <input type="text" class="form-control" name="documento" value="<?php echo $documento; ?>" maxlength="20" autocomplete = "off"/> 
                    </div></br>
                    
                    <div class="form-input"> </br>
                         <button type="submit" name="reg_btn" class="btn btn-outline-dark"  value ="registrati"> Registrati </button>
                    </div>
                    <div class="text-center mt-4"> <span>Sei già un membro?</span> <a href="login.php" class="text-decoration-none">Accedi</a> </div>
                    </div>
               </div>
          </div>
          </div>    
</form>
</body>
<?php include('includes/footer.php'); ?>
</html>
