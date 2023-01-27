<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

// SELECT 
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
   if (isset($_GET['correoUsuario']) && isset($_GET["passwordUsuario"]))
  {
   $sql = $dbConn->prepare("SELECT * from usuario  where correoUsuario=:correoUsuario and passwordUsuario=:passwordUsuario");
   $sql->bindValue(':correoUsuario', $_POST['correoUsuario']);
   $sql->bindValue(':passwordUsuario', $_POST['passwordUsuario']);
   $sql->execute();
   header("HTTP/1.1 200 OK");
   echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
   exit();
  }
}
header("HTTP/1.1 400 Bad Request");
?>