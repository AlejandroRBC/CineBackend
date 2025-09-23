<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include "../../../Capa_Negocio/Modulo-cartelera/ResenasN.php";
include_once __DIR__ . "/../../../Capa_Datos/conexionBD/conexion.php";
$data = LogicaResenas($conexion);
if (!$data['pelicula']) {
    header("Location: ../../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseñas - <?= htmlspecialchars($data['pelicula']['nom_pel']) ?></title>
    <link rel="stylesheet" href="../../CSS/Sidebar/sidebar.css">
    <link rel="stylesheet" href="../../CSS/Cartelera/resenas.css">
    <script src="../../JAVASCRIPT/Sidebar/sidebar.js"></script>
    <script src="../../JAVASCRIPT/Cartelera/resena.js"></script>
</head>
<body>
    <?php
    define("BASE_URL", "/CineBackend/");
    
    include('../../PHP/Sidebar/sidebar.php');
    ?>

    <div class="contenido-principal">
        <div class="content-cabeza">
            <a href="../../../index.php" class="btn-volver">← Volver al Inicio</a>
            <h1><?= htmlspecialchars($data['pelicula']['nom_pel']) ?></h1>
            <div class="info-pelicula">
                <p><strong>Formato:</strong> <?= $data['pelicula']['formato'] ?></p>
                <p><strong>Categoría:</strong> <?= $data['pelicula']['categoria'] ?></p>
                
                <?php if ($data['promedio']['total'] > 0): ?>
                    <div class="calificacion-promedio">
                        <strong>Calificación promedio:</strong>
                        <div class="estrellas">
                            
                            <?php
                                $promedio = round($data['promedio']['promedio'], 1);
                            ?>
                            
                            <span class="puntuacion">(<?= $promedio ?>/5 - <?= $data['promedio']['total'] ?> reseñas)</span>
                        </div>
                    </div>
                <?php else: ?>
                    <p><strong>Calificación:</strong> Sin reseñas aún</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="contenido-cuerpo">
            <!-- Formulario para agregar reseña -->
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if (!$data['usuarioYaReseno']): ?>
                    <div class="agregar-resena">
                        <h3>Agregar tu Reseña</h3>
                        <form method="POST">
                            <div class="calificacion-input">
                                <label>Calificación:</label>
                                <div class="estrellas-seleccion">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <input type="radio" name="calificacion" value="<?= $i ?>" id="star<?= $i ?>">
                                        <label for="star<?= $i ?>" class="estrella-seleccionable">★</label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <div class="comentario-input">
                                <label for="comentario">Comentario:</label>
                                <textarea name="comentario" id="comentario" rows="4" 
                                        placeholder="Escribe tu opinión sobre la película..." 
                                        required></textarea>
                            </div>
                            
                            <button type="submit" name="agregar_resena" class="btn-enviar">Enviar Reseña</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="mensaje-info">
                        <p>✅ Ya has agregado una reseña para esta película.</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="mensaje-info">
                    <p>🔒 <a href="../../PHP/Login-Usuarios/login_usuario.php">Inicia sesión</a> para agregar una reseña.</p>
                </div>
            <?php endif; ?>

            <!-- Mensajes de error o éxito -->
            <?php if (isset($data['error'])): ?>
                <div class="mensaje-error">
                    <p><?= htmlspecialchars($data['error']) ?></p>
                </div>
            <?php endif; ?>

            <!-- Lista de reseñas -->
            <div class="lista-resenas">
                <h3>Reseñas de Usuarios (<?= $data['resenas']->num_rows ?>)</h3>
                
                <?php if ($data['resenas']->num_rows > 0): ?>
                    <?php while ($resena = $data['resenas']->fetch_assoc()): ?>
                        <div class="resena-item">
                            <div class="resena-header">
                                <div class="usuario-info">
                                    <strong><?= htmlspecialchars($resena['nombre'] ?: $resena['nom_usu']) ?></strong>
                                    
                                </div>
                                <div class="calificacion-resena">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="estrella <?= $i <= $resena['puntuacion'] ? 'llena' : 'vacia' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="comentario-resena">
                                <p><?= nl2br(htmlspecialchars($resena['comentario'])) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="sin-resenas">
                        <p>No hay reseñas para esta película aún. ¡Sé el primero en opinar!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>