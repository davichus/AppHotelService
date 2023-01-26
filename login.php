<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

if(isset($_GET["usuario"]) && isset($_GET["pass"])){
    $usuario=$_GET['usuario'];
    $pass=$_GET['pass'];
    
    $conexion=mysqli_connect($hostname_localhost,$usuarioname_localhost,$password_localhost,$database_localhost);
    
    $consulta="SELECT usuario, pass FROM user WHERE usuario= '{$usuario}' AND pass = '{$pass}'";
    $resultado=mysqli_query($dbConn,$consulta);

    if($consulta){
    
        if($registro=mysqli_fetch_array($resultado)){
            $json['datos'][]=$registro;
            
        }
        mysqli_close($conexion);
        echo json_encode($json);
    }



    else{
        $results["usuario"]='No Registra';
        $results["pass"]='No Registra';
        $results["nombre"]='No Registra';
        $json['datos']['']=$results;
        echo json_encode($json);
    }
    
}
else{
        $results["usuario"]='No Retorna';
        $results["pass"]='No Retorna';
        $results["nombre"]='No Retorna';
        $json['usuarios'][]=$results;
        echo json_encode($json);
    }'

?>