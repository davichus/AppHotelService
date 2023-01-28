<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['usuario']) && isset($_GET['contrasenaUsuario']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from Usuario  where usuario =:usuario and contrasenaUsuario =:contrasenaUsuario");
      $sql->bindValue(':usuario', $_GET['usuario']);
      $sql->bindValue(':contrasenaUsuario', $_GET['contrasenaUsuario']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      //echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      echo json_encode( $sql->fetchAll()  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM Usuario");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}
?>