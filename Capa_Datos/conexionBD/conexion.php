<?php

$host = "localhost";
$usuario = "root";    
$password = "";          
$basedatos = "cine";      

$conexion = new mysqli($host, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

?>
