<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['correoUsuario']) && isset($_POST["passwordUsuario"]))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from usuario  where correoUsuario=:correoUsuario and passwordUsuario=:passwordUsuario");
      $sql->bindValue(':correoUsuario', $_POST['correoUsuario']);
      $sql->bindValue(':passwordUsuario', $_POST['passwordUsuario']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }else{
        echo json_encode("ERROR");
      }


}

?>