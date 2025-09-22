<?php
    include __DIR__ . "/../conexionBD/conexion.php";
    
    function ListarProductosDisponibles($conexion){
        $sql = "SELECT * FROM productos";
        return $conexion->query($sql);
    }

?>
