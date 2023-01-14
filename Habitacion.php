<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idHabitacion']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * Habitacion  where idHabitacion=:idHabitacion");
      $sql->bindValue(':idHabitacion', $_GET['idHabitacion']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
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

//INSERTAR
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
     $input = $_POST;
     $sql="INSERT INTO Habitacion
           (idHabitacion, idHotel, codigoHabitacion, tipoHabitacion, nombreHabitacion, foto1Habitacion, foto2Habitacion, capacidadHabitacion, precioHabitacion, estadoHabitacion) 
           VALUES 
           (NULL, :idHotel, :codigoHabitacion, :tipoHabitacion, :nombreHabitacion, :foto1Habitacion, :foto2Habitacion, :capacidadHabitacion, :precioHabitacion, 'A')";

     $statement = $dbConn->prepare($sql);
     bindAllValues($statement, $input);
     $statement->execute();
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idHabitacion'] = $postCodigo;
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
	$codigo = $_GET['idHabitacion'];
  $statement = $dbConn->prepare("DELETE FROM  Habitacion where idHabitacion=:idHabitacion");
  $statement->bindValue(':idHabitacion', $codigo);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar

if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postCodigo = $input['idHabitacion'];
    $fields = getParams($input);

    $sql = "
          UPDATE Habitacion
          SET $fields
          WHERE idHabitacion='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado


?>