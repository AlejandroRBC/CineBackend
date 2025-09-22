<?php
    include "../conexionBd/conexion.php";
    function ListarPeliculas($conexion){
        $sql = "SELECT * FROM pelicula";
        return $conexion->query($sql);
    }
?>