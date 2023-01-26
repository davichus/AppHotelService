<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET["correoUsuario"]) && isset($_GET["passwordUsuario"]))
    {
        $usuario=$_GET['correoUsuario'];
        $pass=$_GET['passwordUsuario'];
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT correoUsuario, passwordUsuario from usuario  where usuario= '{$usuario}' AND pass = '{$pass}'");
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
      else{
        $sql["usuario"]='No Registra';
        $sql["pass"]='No Registra';
        echo json_encode($json);
    }


}


?>