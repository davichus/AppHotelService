<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_GET['correoUsuario']) && isset($_GET["passwordUsuario"]))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from usuario  where correoUsuario=:correoUsuario and passwordUsuario=:passwordUsuario");
      $sql->bindValue(':correoUsuario', $_GET['correoUsuario']);
      $sql->bindValue(':passwordUsuario', $_GET['passwordUsuario']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }


}

?>