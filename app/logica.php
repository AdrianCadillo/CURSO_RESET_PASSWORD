<?php 
 session_start();
 require '../database/Conexion.php';
# login de acceso
 if(isset($_POST['login']))
 {
    /// realiza el proceso de login

  if(isset($_POST['name']) and $_POST['password'])
  {
   $login = $_POST['name'];

   $Password  = $_POST['password'];

   login(
    ["name"=>$login,
     "password"=>$Password
    ]
  );
  }
  else
  {
    $_SESSION['error'] = 'Ingrese sus credenciales';
    header("location:../view/login.php");
  }

 }

 # registrar nuevos usuarios

 if(isset($_POST['registrate']))
 {
     /// crear las variables para los datos a enviar
     $Name = $_POST['name'] ?? '';
     $Password = $_POST['password'];
     $Rol = $_POST['rol'];
     $Email = $_POST['email'];

    $respuesta =  saveUser([
        "name"=>$Name,
        "email"=>$Email,
        "password"=>password_hash($Password,PASSWORD_BCRYPT),
        "rol"=>$Rol
     ]);

    $Mensaje = $respuesta? 'usuario registrado':'error al registrar usuario';

    $_SESSION['mensaje'] = $Mensaje;

    header("location:../view/registrate.php");
 }


 /** 
  * Método para registrar usuario
  */

  function saveUser(array $datos)
  {
  try {
    $Conex = new Conexion;

    $MiConexion = $Conex->getConection();
 
    $Conex->pps = $MiConexion->prepare(
     "INSERT INTO usuarios(name,email,password,rol) VALUES(:name,:email,:password,:rol)"
    );
 
    $Conex->pps->bindParam(":name",$datos['name']);$Conex->pps->bindParam(":email",$datos['email']);
     $Conex->pps->bindParam(":password",$datos['password']);
    $Conex->pps->bindParam(":rol",$datos['rol']);
 
    return $Conex->pps->execute(); /// 1 | 0
  } catch (\Throwable $th) {
    echo $th->getMessage();
  }finally
  {
    $Conex->closeDataBase();
  }
  }

  /// realizar el login al sistema
  function login(array $credenciales)
  {
    /// consultar a la base de datos
    $conex = new Conexion;

    $Usuario = ConsultaUsuario($conex,["name"=>$credenciales['name']]);

     if(count($Usuario) > 0)
     {
      $UserName = $Usuario[0]['name']; 
      $Email = $Usuario[0]['email'];

      $HashPassword = $Usuario[0]['password'];

      if($UserName === $credenciales['name'] or $Email === $credenciales['name'])
      {
       /// hacemos la verificación del password

        if(password_verify($credenciales['password'],$HashPassword))
        {
          header("location:../view/dashboard.php");
        }
        else
        {
           $_SESSION['error'] = 'Error en password';
         header("location:../view/login.php");
        }
      }
      else
      {
        $_SESSION['error'] = 'Error en el nombre de usuario';
         header("location:../view/login.php");
      }
     }
     else
     {
      $_SESSION['error'] = 'Error, no existe ese usuario';
       header("location:../view/login.php");
     }
  }

  /// consultamos al usuario
  function ConsultaUsuario($conexion,array $dataConsulta)
  {
    $consulta = "
    SELECT *FROM usuarios WHERE name =:name or email=:email
    ";

    try {
    $conexion->pps = $conexion->getConection()->prepare($consulta);

    $conexion->pps->bindParam(":name",$dataConsulta['name']);
    $conexion->pps->bindParam(":email",$dataConsulta['name']);

    $conexion->pps->execute();

    return $conexion->pps->fetchAll();

    } catch (Exception $e) {
      echo $e->getMessage();
    }finally{
      $conexion->closeDataBase();
    }


  }
