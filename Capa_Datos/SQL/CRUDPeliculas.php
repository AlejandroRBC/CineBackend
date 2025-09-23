<?php
    include __DIR__ . "/../conexionBD/conexion.php";
    function ListarPeliculasHabilitadas($conexion){
        $sql = "SELECT * FROM pelicula  WHERE estado like 'EN_PROYECCION'";
        return $conexion->query($sql);
    }
    function BuscarPeliculas($conexion, $terminoBusqueda){
        $sql = "SELECT * FROM pelicula 
                WHERE estado = 'EN_PROYECCION' 
                AND (nom_pel LIKE ? OR categoria LIKE ? OR lenguaje LIKE ?)
                ORDER BY nom_pel";
        
        $stmt = $conexion->prepare($sql);
        $terminoLike = "%" . $terminoBusqueda . "%";
        $stmt->bind_param("sss", $terminoLike, $terminoLike, $terminoLike);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    
    function ObtenerPeliculasPorCategoria($conexion, $categoria){
        $sql = "SELECT * FROM pelicula 
                WHERE estado = 'EN_PROYECCION' 
                AND categoria LIKE ?
                ORDER BY nom_pel";
        
        $stmt = $conexion->prepare($sql);
        $categoriaLike = "%" . $categoria . "%";
        $stmt->bind_param("s", $categoriaLike);
        $stmt->execute();
        
        return $stmt->get_result();
    }
?>