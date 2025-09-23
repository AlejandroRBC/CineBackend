<?php
    include __DIR__ . "/../conexionBD/conexion.php";
    
    function ListarProductosDisponibles($conexion){
        $sql = "SELECT * FROM productos WHERE stock>0 AND activo like 'Activo'";
        return $conexion->query($sql);
    }

?>
