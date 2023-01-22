<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['idtipo']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * from tipoHabitacion  where idtipo=:idtipo");
      $sql->bindValue(':idtipo', $_GET['idtipo']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM tipoHabitacion");
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
     $sql="INSERT INTO tipoHabitacion
           (idtipo, descTipo) 
           VALUES 
           (NULL, :nombreHotel, :descTipo)";

     $statement = $dbConn->prepare($sql);
     bindAllValues($statement, $input);
     $statement->execute();
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idtipo'] = $postCodigo;
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
	$codigo = $_GET['idtipo'];
  $statement = $dbConn->prepare("DELETE FROM  tipoHabitacion where idtipo=:idtipo");
  $statement->bindValue(':idtipo', $codigo);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar

if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postCodigo = $input['idHotel'];
    $fields = getParams($input);

    $sql = "
          UPDATE tipoHabitacion
          SET $fields
          WHERE idtipo='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado


?>