<?php
include "../../../Capa_datos/conexionBD/conexion.php";

function ListarResenasPorPelicula($conexion, $idPelicula) {
    $sql = "SELECT r.*, u.nom_usu, u.nombre 
            FROM reseña r 
            JOIN USUARIO u ON r.idUsuario = u.idUsuario 
            WHERE r.idPelicula = ? AND r.estado = 'En proyección'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPelicula);
    $stmt->execute();
    return $stmt->get_result();
}

function AgregarResena($conexion, $idPelicula, $idUsuario, $puntuacion, $comentario) {
    $sql = "INSERT INTO reseña (idPelicula, idUsuario, puntuacion, comentario) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiis", $idPelicula, $idUsuario, $puntuacion, $comentario);
    return $stmt->execute();
}

function ObtenerPromedioCalificacion($conexion, $idPelicula) {
    $sql = "SELECT AVG(puntuacion) as promedio, COUNT(*) as total 
            FROM reseña 
            WHERE idPelicula = ? AND estado = 'En proyección'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPelicula);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function VerificarUsuarioYaReseno($conexion, $idPelicula, $idUsuario) {
    $sql = "SELECT COUNT(*) as total 
            FROM reseña 
            WHERE idPelicula = ? AND idUsuario = ? AND estado = 'En proyección'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $idPelicula, $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();
    return $resultado['total'] > 0;
}
?>