<?php

include_once __DIR__ . "../../../Capa_Datos/conexionBD/conexion.php";
include_once __DIR__ . '../../../Capa_Datos/SQL/CRUDPeliculas.php';

// Configurar headers para evitar cache
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termino = $_POST['termino'] ?? '';
    $accion = $_POST['accion'] ?? '';
    
    if ($accion === 'buscar' && !empty($termino)) {
        mostrarPeliculas(BuscarPeliculas($conexion, $termino), $termino);
    } else {
        mostrarPeliculas(ListarPeliculasHabilitadas($conexion));
    }
    
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'inicial') {
    mostrarPeliculas(ListarPeliculasHabilitadas($conexion));
    
} 

function mostrarPeliculas($resultado, $terminoBusqueda = '') {
    if ($resultado->num_rows > 0) {
        echo '<div>';
        
        while($pelicula = $resultado->fetch_assoc()) {
            $titulo = htmlspecialchars($pelicula['nom_pel']);
            $categoria = htmlspecialchars($pelicula['categoria'] ?? 'Sin categoría');
            $formato = htmlspecialchars($pelicula['formato'] ?? '2D');
            $clasificacion = htmlspecialchars($pelicula['clasificacion'] ?? 'NR');
            $lenguaje = htmlspecialchars($pelicula['lenguaje'] ?? 'Español');
            
            // Resaltar término de búsqueda en el título
            if (!empty($terminoBusqueda)) {
                $titulo = preg_replace(
                    "/(" . preg_quote($terminoBusqueda, '/') . ")/i", 
                    "<mark>$1</mark>", 
                    $titulo
                );
            }
            
            echo '
            <div class="pelicula-card" onclick="seleccionarPelicula(' . $pelicula['idPelicula'] . ')">
                <div class="pelicula-imagen">
                </div>
                <div class="pelicula-content">
                    <div class="pelicula-titulo">' . $titulo . '</div>
                    
                    <div class="pelicula-info">
                        <span>Idioma:</span>
                        <span>' . $lenguaje . '</span>
                    </div>
                    
                    <div class="pelicula-info">
                        <span>Formato:</span>
                        <span class="pelicula-etiqueta pelicula-formato">' . $formato . '</span>
                    </div>
                    
                    <div style="display: flex; gap: 5px; margin-top: 10px; flex-wrap: wrap;">
                        <span class="pelicula-etiqueta pelicula-categoria">' . $categoria . '</span>
                        <span class="pelicula-etiqueta pelicula-clasificacion">' . $clasificacion . '</span>
                    </div>
                </div>
            </div>';
        }
        
        echo '</div>';
        
    } else {
        echo '
        <div class="sin-resultados">
            <div>🎭</div>
            <h3>No se encontraron películas</h3>
            <p>' . (!empty($terminoBusqueda) ? 
                'No hay resultados para "<strong>' . htmlspecialchars($terminoBusqueda) . '</strong>". Intenta con otros términos.' : 
                'No hay películas en cartelera en este momento.') . '</p>
        </div>';
    }
}

function seleccionarPelicula($idPelicula) {
    // Redirigir a la página de compra con la película seleccionada
    header('Location: ../venta-transaccion/comprar.php?pelicula=' . $idPelicula);
    exit();
}
?>