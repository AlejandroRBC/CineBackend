<?php
    include __DIR__ . "/../conexionBD/conexion.php";

    function ListarPeliculasHabilitadas($conexion){
        $sql = "SELECT * FROM pelicula  WHERE estado like 'EN_PROYECCION'";
        return $conexion->query($sql);
    }
?>