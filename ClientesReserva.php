<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idCliente']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from Cliente  where idCliente =:idCliente");
      $sql->bindValue(':idCliente', $_GET['idCliente']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      //echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      echo json_encode( $sql->fetchAll()  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT c.idCliente, c.idUsuario, u.nombreUsuario,u.apellidoUsuario FROM Cliente c INNER join Usuario u on c.idUsuario=u.idUsuario");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}
?>