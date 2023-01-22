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
      $sql = $dbConn->prepare("SELECT * from Hotel  where idHotel=:idHotel");
      $sql->bindValue(':idHotel', $_GET['idHotel']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }

	  else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM Hotel");
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
     $sql="INSERT INTO Hotel
           (idHotel, nombreHotel, descripcionHotel, correoHotel, direccionHotel, ubicacionHotel, telefonoHotel, fotoHotel,estadoHotel) 
           VALUES 
           (NULL, :nombreHotel, :descripcionHotel, :correoHotel, :direccionHotel, :ubicacionHotel, :telefonoHotel, :fotoHotel,'A')";

     $statement = $dbConn->prepare($sql);
     bindAllValues($statement, $input);
     $statement->execute();
     $postCodigo = $dbConn->lastInsertId();
     if($postCodigo)
     {
       $input['idHotel'] = $postCodigo;
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
	$codigo = $_GET['idHotel'];
  $statement = $dbConn->prepare("DELETE FROM  Hotel where idHotel=:idHotel");
  $statement->bindValue(':idHotel', $codigo);
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
          UPDATE Hotel
          SET $fields
          WHERE idHotel='$postCodigo'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado


?>