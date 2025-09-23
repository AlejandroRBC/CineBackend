<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cine";

$conexion = new mysqli($host, $user, $pass);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$result = $conexion->query("SHOW DATABASES LIKE '$db'");
if ($result->num_rows == 0) {
    
    $sqlScript = file_get_contents(__DIR__ . '../../SQL/cine.sql');
    if ($conexion->multi_query($sqlScript)) {
        do {
            if ($res = $conexion->store_result()) {
                $res->free();
            }
        } while ($conexion->more_results() && $conexion->next_result());
        
    } else {
        die("Error ejecutando el script SQL: " . $conexion->error);
    }
}

$conexion->select_db($db);
?>
