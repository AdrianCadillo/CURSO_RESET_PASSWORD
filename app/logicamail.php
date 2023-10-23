<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require '../config/setting.php';
 require '../database/Conexion.php';
 if(isset($_POST['send'])):
    
    if(!empty($_POST['email']))
    {
        if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $Usuario = ConsultarUsuarioPorEmail($_POST['email']);
            if(count($Usuario) > 0)
            {
             /// enviar el correo

             $token_ = bin2hex(random_bytes(32));

             if(updateUser($token_,TIEMPO_VIDA,$Usuario[0]->id_usuario));
             {
          /// mandamos actualziar
             EnviarCorreoResetPassowrd($Usuario[0]->email, $Usuario[0]->name,$Usuario[0]->id_usuario,$token_);
             }
            }
            else
            {
               $_SESSION['response'] = "no existe usuario";
            } 
        }
        else
        {
          $_SESSION['response'] = 'email incorrecto';
        }
    }
    else
    {
        $_SESSION['response'] = 'input vacio';
    }
    
    /// redirigimos 
    //header("location:../view/reset_password.php");
 endif;

 /// método que consulta al usuario por correo

 function ConsultarUsuarioPorEmail($email)
 {
  $conex = new Conexion;

  /// consultamos

  $conex->sql = "SELECT *FROM usuarios WHERE email=:email";

  try {
   $conex->pps = $conex->getConection()->prepare($conex->sql);
   $conex->pps->bindParam(":email",$email);
   $conex->pps->execute();

   return $conex->pps->fetchAll(PDO::FETCH_OBJ);

  } catch (\Throwable $th) {
     echo $th->getMessage();
  }finally{
    $conex->closeDataBase();
  }
 }

 /// actualizamos usuario
 function updateUser($token,$tiempo_vida,$User_Id)
 {
  $conex = new Conexion();
  $Valor = "1";

  $conex->sql = "UPDATE usuarios set request_password=:request_password,token_password=:token_password,expired_session=:expired_session where id_usuario=:id_usuario";

  try {
     $conex->pps = $conex->getConection()->prepare($conex->sql);
     $conex->pps->bindParam(":request_password",$Valor);
     $conex->pps->bindParam(":token_password",$token);
     $conex->pps->bindParam(":expired_session",$tiempo_vida);
     $conex->pps->bindParam(":id_usuario",$User_Id);

     return $conex->pps->execute();

  } catch (\Throwable $th) {
     echo $th->getMessage();
  }
 }

 /**
  * envio de correos electronicos
  */
  function EnviarCorreoResetPassowrd($Correo,$NombreReceptor,$userid,$token_User)
  {
   $mail = new PHPMailer(true);
   try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = HOST;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = USERNAME;                     //SMTP username
    $mail->Password   = PASSWORD;                               //SMTP password
    $mail->SMTPSecure = SMTP_SECURE;            //Enable implicit TLS encryption
    $mail->Port       = PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('Soporte@TecnologySoft.com', 'Soporte');
    $mail->addAddress($Correo, $NombreReceptor);     //Add a recipient
  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reseteo de password';
    $mail->Body    = 'Usted a solicitado un reseteo de contraseña<b> 
    <a href="https://reset_password.com/view/Cambiar_password.php?id='.$userid.'&&token='.$token_User.'">cambiar contraseña aquí</a></b>';

    $mail->send();
    echo 'Mensaje enviado';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
  }

  
