<?php 
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
   <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-6 col-lg-5 col-md-6 col-sm-9 col-12">
        <div class="card">
            <div class="card-header bg bg-primary">
                <p class="h4 text-white">Login</p>
            </div>

           <form action="../app/logica.php" method="post">
           <div class="card-body">

                <?php 
                 if(isset($_SESSION['error'])):
                 ?>
                  <div class="alert alert-danger">
                    <?php echo  $_SESSION['error']; ?>
                  </div>
                 <?php unset($_SESSION['error']); endif;?>
                 
                <div class="form-group">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" name="name" id="name" class="form-control" >
                </div> 
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" >
                </div> 
                <a href="reset_password.php">Olvidaste la contraseña ?</a>
                <a href="registrate.php">¿Eres nuevo usuario? Registrate aquí</a>
           </div>

           <div class="card-footer">
            <button class="btn btn-primary" name="login">entrar</button>
            <button type="reset" class="btn btn-danger">Cancelar</button>
           </div>
           </form>
        </div>
        </div>
    </div>
   </div> 
</body>
</html>