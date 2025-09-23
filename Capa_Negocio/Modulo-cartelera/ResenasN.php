<?php

include "../../../Capa_datos/conexionBD/conexion.php";
include "CRUDResenas.php";

function LogicaResenas($conexion) {
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $resultado = [];
    
    // Obtener ID de película desde GET
    $idPelicula = $_GET['id'] ?? 0;
    $resultado['idPelicula'] = $idPelicula;
    
    // Obtener información de la película
    $sqlPelicula = "SELECT * FROM pelicula WHERE idPelicula = ?";
    $stmt = $conexion->prepare($sqlPelicula);
    $stmt->bind_param("i", $idPelicula);
    $stmt->execute();
    $resultado['pelicula'] = $stmt->get_result()->fetch_assoc();
    
    // Obtener reseñas de la película
    $resultado['resenas'] = ListarResenasPorPelicula($conexion, $idPelicula);
    
    // Obtener promedio de calificación
    $resultado['promedio'] = ObtenerPromedioCalificacion($conexion, $idPelicula);
    
    // Verificar si el usuario ya reseñó esta película
    if (isset($_SESSION['usuario'])) {
        $resultado['usuarioYaReseno'] = VerificarUsuarioYaReseno(
            $conexion, 
            $idPelicula, 
            $_SESSION['usuario']['id']
        );
    } else {
        $resultado['usuarioYaReseno'] = false;
    }
    
    // Procesar nueva reseña
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_resena'])) {
        if (!isset($_SESSION['usuario'])) {
            $resultado['error'] = "Debe iniciar sesión para agregar una reseña";
        } elseif ($resultado['usuarioYaReseno']) {
            $resultado['error'] = "Ya has agregado una reseña para esta película";
        } else {
            $puntuacion = $_POST['puntuacion'] ?? 0;
            $comentario = $_POST['comentario'] ?? '';
            
            if ($puntuacion >= 1 && $puntuacion <= 5 && !empty(trim($comentario))) {
                if (AgregarResena($conexion, $idPelicula, $_SESSION['usuario']['id'], $puntuacion, $comentario)) {
                    $resultado['exito'] = "Reseña agregada correctamente";
                    // Recargar datos
                    header("Location: ?id=" . $idPelicula);
                    exit();
                } else {
                    $resultado['error'] = "Error al agregar la reseña";
                }
            } else {
                $resultado['error'] = "Calificación y comentario son requeridos";
            }
        }
    }
    return $resultado;
}
?>