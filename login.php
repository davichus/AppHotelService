<?php
#include "config.php";
#include "utils.php";

#$dbConn =  connect($db);

// SELECT 
#if ($_SERVER['REQUEST_METHOD'] == 'POST')
#{
 #   if (isset($_POST['correoUsuario']) && isset($_POST["passwordUsuario"]))
  #  {
   #   $sql = $dbConn->prepare("SELECT * from usuario  where correoUsuario=:correoUsuario and passwordUsuario=:passwordUsuario");
    #  $sql->bindValue(':correoUsuario', $_POST['correoUsuario']);
    #  $sql->bindValue(':passwordUsuario', $_POST['passwordUsuario']);
     # $sql->execute();
     # header("HTTP/1.1 200 OK");
     # echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      #exit();
	  #}


#}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = json_decode(file_get_contents("php://input"));
$username = $postdata->correoUsuario;
$password = $postdata->passwordUsuario;

$db_host = "localhost"; 
$db_user = "root"; 
$db_pass = ""; 
$db_name = "AppHotelDB"; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuario WHERE correoUsuario = '$username' AND passwordUsuario='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $token = bin2hex(random_bytes(16));
    $userId = $user['user_id'];
    $sql = "UPDATE users SET token='$token' WHERE user_id=$userId";
    $result = $conn->query($sql);
    $returnData = array('success' => true, 'message' => 'Logged in successfully', 'data' => array('userId' => $userId, 'token' => $token));
} else {
    $returnData = array('success' => false, 'message' => 'Invalid username/password');
}

$conn->close();

echo json_encode($returnData);
?>