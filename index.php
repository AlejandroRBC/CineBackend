<link rel="stylesheet" href="Capa_presentacion/CSS/Sidebar/sidebar.css">
<link rel="stylesheet" href="Capa_presentacion/CSS/Cartelera/card.css">
<link rel="stylesheet" href="Capa_presentacion/CSS/Venta-Transaccion/footer.css">
<script src="Capa_presentacion/JAVASCRIPT/Sidebar/sidebar.js"></script>
<script src="Capa_presentacion/JAVASCRIPT/Cartelera/resenas.js"></script>
<?php 
    define("BASE_URL", "/CineBackend/");
    include('Capa_Presentacion/PHP/Sidebar/sidebar.php');
    include_once __DIR__ . "/Capa_Datos/conexionBD/conexion.php";
    include_once __DIR__ . "/Capa_Datos/SQL/CRUDPeliculas.php";
    $peliculas = ListarPeliculasHabilitadas($conexion);
?>
<div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Bienvenido a CineMax</h1>
        Observa nuestras peliculas
    </div>
    <div class="contenido-cuerpo">
        <h2>Cartelera De peliculas</h2>
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
                            <button type="button" onclick="Hola()" class="Enter">Informacion</button> 
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
