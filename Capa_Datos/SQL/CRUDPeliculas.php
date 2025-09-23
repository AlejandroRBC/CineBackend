<?php
    include __DIR__ . "/../conexionBD/conexion.php";
    function ListarPeliculasHabilitadas($conexion){
        $sql = "SELECT * FROM pelicula  WHERE estado like 'EN_PROYECCION'";
        return $conexion->query($sql);
    }

function ListarProximosEstrenos($conexion, $limite = 5) {
    $sql = "SELECT idPelicula, nom_pel, fecha_lanzamiento, formato, categoria
            FROM pelicula
            WHERE fecha_lanzamiento > CURDATE()
            ORDER BY fecha_lanzamiento ASC
            LIMIT ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $limite);
    $stmt->execute();
    return $stmt->get_result();
}

?>