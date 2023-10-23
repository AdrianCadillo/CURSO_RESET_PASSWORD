<?php 
  session_start();

  require_once '../database/Conexion.php';

  $conexion = new Conexion();
 

  $MiConexion = $conexion->getConection();

  $conexion->sql = "SELECT *FROM usuarios where id_usuario=? and
  token_password=?  ";

  try {
    $conexion->pps = $MiConexion->prepare($conexion->sql);
    $conexion->pps->bindParam(1,$_GET['id']);
    $conexion->pps->bindParam(2,$_GET['token']);
 

    $conexion->pps->execute();

    $data = $conexion->pps->fetchAll(PDO::FETCH_OBJ);
  } catch (\Throwable $th) {
    echo $th->getMessage();
  }finally{
    $conexion->closeDataBase();
  }

if(count($data)>0 and $data[0]->expired_session > time()):
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contrasenia</title>
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
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" >
                </div> 
                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirmar Password</label>
                    <input type="password_confirm" name="password_confirm" id="password_confirm" class="form-control" >
                </div> 
 
               
           </div>

           <div class="card-footer">
            <button class="btn btn-primary" name="save">Guardar</button>
            <button type="reset" class="btn btn-danger">Cancelar</button>
           </div>
           </form>
        </div>
        </div>
    </div>
   </div> 
</body>
</html>
<?php else: header("location:login.php"); endif; ?>
 

 