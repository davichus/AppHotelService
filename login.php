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

//update the above with your database credentials
header("Content-Type:application/json");
$con=mysqli_connect("localhost","root","","AppHotelDB");
$email = $_POST["correoUsuario"];
$password = $_POST["passwordUsuario"];
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM usuario WHERE correoUsuario='$email' AND passwordUsuario='$password'"))> 0){

    $json = array("status" => 200,'message' => "Success");
    
    }else{
        $json = array("status" => 300,'message' => "Error");
    }

?>