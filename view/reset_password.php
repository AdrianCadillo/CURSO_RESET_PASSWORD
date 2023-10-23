<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reset-Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
   <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-6 col-lg-5 col-md-6 col-sm-9 col-12">
        <div class="card">
            <div class="card-header bg bg-primary">
                <p class="h4 text-white">Reset Password</p>
            </div>

           <form action="../app/logicamail.php" method="post">
           <div class="card-body">
                <div class="form-group">
                    <label for="email" class="form-label">Escriba su email</label>
                    <input type="text" name="email" id="email" class="form-control" >
                </div> 
                
           </div>

           <?php 
           if(isset($_SESSION['response'])):
           ?>

            <h2><?php echo $_SESSION['response'] ;?></h2>
            
           <?php unset($_SESSION['response']); endif; ?>

           <div class="card-footer">
            <button class="btn btn-primary" name="send">enviar</button>
            <button type="reset" class="btn btn-danger">Cancelar</button>
           </div>
           </form>
        </div>
        </div>
    </div>
   </div> 
</body>
</html>