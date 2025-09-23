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
    include_once __DIR__ . "/Capa_Datos/SQL/CRUDPeliculas.php";
    include('Capa_Negocio/Modulo-cartelera/buscador.php');
    $peliculas = ListarPeliculasHabilitadas($conexion);
    
?>
<div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Bienvenido a CineMax</h1>
        Observa nuestras peliculas
    </div>
    <div class="contenido-cuerpo">
        <h2>Cartelera De peliculas</h2>

        <!-- Buscador de Películas -->
        <div class="buscador-container">
            <form id="formBuscar" class="buscador-form">
                <input 
                    type="text" 
                    id="inputBuscar" 
                    class="buscador-input" 
                    placeholder="Buscar por título, categoría o idioma..."
                    autocomplete="off"
                >
                <button type="submit" id="btnBuscar" class="buscador-btn">Buscar</button>
                <button type="button" id="btnLimpiar" class="buscador-btn" style="background: #718096;">Limpiar</button>
            </form>
            <!-- Filtros Rápidos -->
            <div class="filtros-container">
                <span style="color: #4a5568; margin-right: 10px;">Filtrar por:</span>
                <button type="button" class="filtro-btn" data-filtro="Acción"> Acción</button>
                <button type="button" class="filtro-btn" data-filtro="Comedia"> Comedia</button>
                <button type="button" class="filtro-btn" data-filtro="Drama"> Drama</button>
                <button type="button" class="filtro-btn" data-filtro="Animación"> Animación</button>
                <button type="button" class="filtro-btn" data-filtro="Terror"> Terror</button>
                <button type="button" class="filtro-btn" data-filtro="Ciencia Ficción"> Ciencia Ficción</button>
            </div>
            <!-- Contador de resultados -->
            <div id="contadorResultados" class="resultados-info"></div>
        </div>
        <!-- Resultados de Búsqueda -->
        <div id="resultadosPeliculas">
            <!-- Las películas se cargarán aquí via JavaScript -->
        </div>


        <div class="contenido-Cuerpo">

        </div>
        <div class="cartelera">
        <?php while($p = $peliculas->fetch_assoc()): ?>
            <div class="card"> 
                <div class="header"> 
                    <div class="content">
                        <span class="titulo"><?= $p['nom_pel'] ?></span> 
                        <p class="descripcion">
                            <strong>Lenguaje</strong> <?= $p['lenguaje'] ?>
                        </p> 
                        <p class="descripcion">
                            <strong>Formato</strong> <?= $p['formato'] ?>
                        </p> 
                        <p class="descripcion">
                            <strong>Categoría</strong> <?= $p['categoria'] ?>
                        </p> 
                    </div> 
                    <div class="acciones">
                            
                            <button type="button" onclick="verResenas(<?= $p['idPelicula'] ?>)" class="Enter">Reseñas</button>
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
