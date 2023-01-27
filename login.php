<?php
//include "config.php";
//include "utils.php";

$dbConn =  connect($db);

// SELECT 
/*if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (isset($_POST['correoUsuario']) && isset($_POST["passwordUsuario"]))
  {
   $sql = $dbConn->prepare("SELECT * from usuario  where correoUsuario=:correoUsuario and passwordUsuario=:passwordUsuario");
   $sql->bindValue(':correoUsuario', $_POST['correoUsuario']);
   $sql->bindValue(':passwordUsuario', $_POST['passwordUsuario']);
   $sql->execute();
   header("HTTP/1.1 200 OK");
   echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
   exit();
  }
}*/

//Incluimos la conexión a la base de datos
require_once('config.php');

//Obtenemos los parámetros enviados
$username = $_POST['correoUsuario'];
$password = $_POST['passwordUsuario'];

//Creamos la consulta
$sql = "SELECT * FROM usuario WHERE username = '$username' AND password = '$password'";

//Ejecutamos la consulta
$result = mysqli_query($dbConn, $sql);

//Verificamos si la consulta devuelve algún resultado
if(mysqli_num_rows($result) > 0 )
{
    //Si la consulta devuelve algún resultado, retornamos un código de "success"
    echo json_encode(array('status'=>'success'));
}
else
{
    //Si la consulta no devuelve ningún resultado, retornamos un código de "error"
    echo json_encode(array('status'=>'error'));
}

//Cerramos la conexión a la base de datos
mysqli_close($con);
?>