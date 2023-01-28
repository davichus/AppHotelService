<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['codigoReserva']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from reserva  where codigoReserva=:codigoReserva");
      $sql->bindValue(':codigoReserva', $_GET['codigoReserva']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM reserva");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}




if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
     $sql="INSERT INTO reserva
           (idReserva, codigoReserva, idCliente, idHotel, idHabitacion, numdiasReserva, horaIngreso, horaSalida, fechaIngreso, fechaSalida, total, estadoReserva)
           VALUES(NULL, :codigoReserva, :idCliente, :idHotel, :idHabitacion, :numdiasReserva, :horaIngreso, :horaSalida, :fechaIngreso, :fechaSalida, :total,'A')";
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $input);
      $statement->execute();
   
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idReserva'] = $postCodigo;
       header("HTTP/1.1 200 OK");
       echo json_encode($input);
       exit();
      }else{
        echo json_encode("ERROR");
      }
    
}
//Eliminar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$codigo = $_GET['idReserva'];
  $statement = $dbConn->prepare("DELETE FROM  reserva where idReserva=:idReserva");
  $statement->bindValue(':idReserva', $codigo);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar

if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postCodigo = $input['idReserva'];
    $fields = getParams($input);

    $sql = "
          UPDATE reserva
          SET $fields
          WHERE idReserva='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado


?>