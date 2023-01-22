<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);
//jj

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idHabitacion']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from Cliente  where idCliente =:idCliente ");
      $sql->bindValue(':idCliente', $_GET['idCliente']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM Cliente");
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
     $sql="INSERT INTO Cliente
           (idCliente, idUsuario , cedulaCliente , idHotel , estadoCliente) 
           VALUES 
           (NULL, :idUsuario, :cedulaCliente, :idHotel,'A')";

     $statement = $dbConn->prepare($sql);
     bindAllValues($statement, $input);
     $statement->execute();
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idCliente'] = $postCodigo;
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
	$codigo = $_GET['idCliente'];
  $statement = $dbConn->prepare("DELETE FROM  Cliente where idCliente=:idCliente");
  $statement->bindValue(':idCliente', $codigo);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar

if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postCodigo = $input['idCliente'];
    $fields = getParams($input);

    $sql = "
          UPDATE Cliente
          SET $fields
          WHERE idCliente='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado


?>