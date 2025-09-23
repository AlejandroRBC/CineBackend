<link rel="stylesheet" href="Capa_presentacion/CSS/Sidebar/sidebar.css">
<link rel="stylesheet" href="Capa_presentacion/CSS/Cartelera/card.css">
<link rel="stylesheet" href="Capa_presentacion/CSS/Cartelera/buscador.css">
<link rel="stylesheet" href="Capa_presentacion/CSS/Venta-Transaccion/footer.css">

<script src="Capa_presentacion/JAVASCRIPT/Sidebar/sidebar.js"></script>
<script src="Capa_presentacion/JAVASCRIPT/Cartelera/resenas.js"></script>
<script src="Capa_presentacion/JAVASCRIPT/Cartelera/buscador.js"></script>

<?php 
define("BASE_URL", "/CineBackend/");
include('Capa_Presentacion/PHP/Sidebar/sidebar.php');
$conexion = include_once __DIR__ . "/Capa_Datos/conexionBD/conexion.php";
include_once __DIR__ . "/Capa_Negocio/Modulo-cartelera/CRUDPeliculas.php";

$peliculas = ListarPeliculasHabilitadas($conexion);
$proximos = ListarProximosEstrenos($conexion);
?>

<div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Bienvenido a CineMax</h1>
        Observa nuestras peliculas
    </div>


<div class="contenido-cuerpo">
    <div class="buscador-container">
        <form id="formBuscar" class="buscador-form" onsubmit="return false;">
            <input type="text" id="inputBuscar" class="buscador-input" placeholder="Buscar por titulo, categoria o lenguaje..." autocomplete="off">
            <button type="submit" id="btnBuscar" class="buscador-btn">Buscar</button>
            <button type="button" id="btnLimpiar" class="buscador-btn" style="background: #718096;">Limpiar</button>
        </form>
        <div class="filtros-container">
            <span >Filtrar por:</span>
            <button type="button" class="filtro-btn" data-filtro="accion">Accion</button>
            <button type="button" class="filtro-btn" data-filtro="comedia">Comedia</button>
            <button type="button" class="filtro-btn" data-filtro="drama">Drama</button>
            <button type="button" class="filtro-btn" data-filtro="animacion">Animacion</button>
            <button type="button" class="filtro-btn" data-filtro="terror">Terror</button>
            <button type="button" class="filtro-btn" data-filtro="ciencia ficcion">Ciencia Ficcion</button>
        </div>
        <div id="contadorResultados" class="resultados-info"></div>
    </div>
</div>


<div class="contenido-cuerpo">
    <h2>Cartelera De Peliculas</h2>
    <div class="cartelera" id="cartelera">
        <?php while($p = $peliculas->fetch_assoc()): ?>
            <div class="card" 
                 data-titulo="<?= strtolower($p['nom_pel']) ?>" 
                 data-categoria="<?= strtolower(str_replace(['á','é','í','ó','ú'],['a','e','i','o','u'],$p['categoria'])) ?>" 
                 data-lenguaje="<?= strtolower($p['lenguaje']) ?>">
                <div class="header"> 
                    <div class="content">
                        <span class="titulo"><?= htmlspecialchars($p['nom_pel']) ?></span> 
                        <p class="descripcion"><strong>Lenguaje:</strong> <?= htmlspecialchars($p['lenguaje']) ?></p> 
                        <p class="descripcion"><strong>Formato:</strong> <?= htmlspecialchars($p['formato']) ?></p> 
                        <p class="descripcion"><strong>Categoria:</strong> <?= htmlspecialchars($p['categoria']) ?></p> 
                    </div> 
                    <div class="acciones">
                        <button type="button" onclick="verResenas(<?= $p['idPelicula'] ?>)" class="Enter2">Reseñas</button>
                    </div> 
                </div> 
            </div>
        <?php endwhile; ?>    
    </div>
</div>
    
    <div class="contenido-cuerpo">
        <h2>Próximos Estrenos</h2>
        <div class="cartelera">
            <?php while($p = $proximos->fetch_assoc()): ?>
                <div class="card"> 
                    <div class="header"> 
                        <div class="content">
                            <span class="titulo"><?= htmlspecialchars($p['nom_pel']) ?></span> 
                            <p class="descripcion"><strong>Estreno:</strong> <?= htmlspecialchars($p['fecha_lanzamiento']) ?></p>
                            <p class="descripcion"><strong>Formato:</strong> <?= htmlspecialchars($p['formato']) ?></p>
                            <p class="descripcion"><strong>Categoría:</strong> <?= htmlspecialchars($p['categoria']) ?></p>
                        </div> 

                        <?php 
                        $trailer_url = '';
                        if (strcasecmp(trim($p['nom_pel']), 'Sonic 2') === 0) {
                            $trailer_url = 'https://www.youtube.com/embed/xMqnQLeQgSw';
                        } elseif (strcasecmp(trim($p['nom_pel']), 'Shrek 4') === 0) {
                            $trailer_url = 'https://www.youtube.com/embed/RSkUcS_Maow';
                        }
                        ?>
                        <?php if ($trailer_url): ?>
                            <div class="trailer">
                                <iframe width="100%" height="250" src="<?= $trailer_url ?>" frameborder="0" allowfullscreen></iframe>
                            </div>
                        <?php endif; ?>

                        <div class="acciones">
                            <button type="button" onclick="verResenas(<?= $p['idPelicula'] ?>)" class="Enter2">Reseñas</button>
                        </div> 
                    </div> 
                </div>
            <?php endwhile; ?>    
        </div>
    </div>

    
    <div class="contenido-cuerpo">
        <?php include('Capa_Presentacion/HTML/Venta-Transaccion/footer.html'); ?>
    </div>
</div>



