<?php
include "../../../Capa_datos/conexionBD/conexion.php";

function ListarResenasPorPelicula($conexion, $idPelicula) {
    $sql = "SELECT r.*, u.nom_usu, u.nombre 
            FROM resena r 
            JOIN USUARIO u ON r.idUsuario = u.idUsuario 
            WHERE r.idPelicula = ? ";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPelicula);
    $stmt->execute();
    return $stmt->get_result();
}

function AgregarResena($conexion, $idPelicula, $idUsuario, $puntuacion, $comentario) {
    $sql = "INSERT INTO resena (idPelicula, idUsuario, puntuacion, comentario) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiis", $idPelicula, $idUsuario, $puntuacion, $comentario);
    return $stmt->execute();
}

function ObtenerPromedioCalificacion($conexion, $idPelicula) {
    $sql = "SELECT AVG(puntuacion) as promedio, COUNT(*) as total 
            FROM resena 
            WHERE idPelicula = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPelicula);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function VerificarUsuarioYaReseno($conexion, $idPelicula, $idUsuario) {
    $sql = "SELECT COUNT(*) as total 
            FROM resena 
            WHERE idPelicula = ? AND idUsuario = ? ";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $idPelicula, $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();
    return $resultado['total'] > 0;
}
?>