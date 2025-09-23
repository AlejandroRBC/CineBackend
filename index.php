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


$proximos = ListarProximosEstrenos($conexion);
?>

<div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Bienvenido a CineMax</h1>
        Observa nuestras películas
    </div>

    <div class="contenido-cuerpo">
        <h2>Cartelera De películas</h2>
        <div class="cartelera">
            <?php while($p = $peliculas->fetch_assoc()): ?>
                <div class="card"> 
                    <div class="header"> 
                        <div class="content">
                            <span class="titulo"><?= htmlspecialchars($p['nom_pel']) ?></span> 
                            <p class="descripcion"><strong>Lenguaje:</strong> <?= htmlspecialchars($p['lenguaje']) ?></p> 
                            <p class="descripcion"><strong>Formato:</strong> <?= htmlspecialchars($p['formato']) ?></p> 
                            <p class="descripcion"><strong>Categoría:</strong> <?= htmlspecialchars($p['categoria']) ?></p> 
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
