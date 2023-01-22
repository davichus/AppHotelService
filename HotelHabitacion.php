<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idHotel']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from Habitacion  where idHotel=:idHotel");
      $sql->bindValue(':idHotel', $_GET['idHotel']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      //echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      echo json_encode( $sql->fetchAll()  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM Habitacion");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}
?>