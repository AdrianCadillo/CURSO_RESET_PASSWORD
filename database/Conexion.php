<?php 
class Conexion 
{
    /**
     * PROPIEDADES PARA LA CONEXIÓN
     */

     private string $Servidor = "localhost";

     private string $BaseDeDatos = "restore_password";

     private string $Usuario = "root";

     private string $Password = "Rosales";

     public string $sql;
     public $pps = null;
     
     private $Conector = null; 


     /**
      * Método que se conecta a la base de datos
      */

      public function getConection(){

        $this->Conector = new PDO(
            "mysql:host=".$this->Servidor.";dbname=".$this->BaseDeDatos,
            $this->Usuario,
            $this->Password
        );

        $this->Conector->exec("set names utf8");

        return $this->Conector;
      }

    /** LIBERAMOS RECURSOS DE LA BASE DE DATOS */
    public function closeDataBase()
    {
        if($this->pps != null)
        {
            $this->pps = null;
        }

        if($this->Conector != null)
        {
            $this->Conector = null;
        }
    }
}
 