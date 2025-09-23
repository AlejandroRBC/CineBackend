<?php

    $base_url = '/CineBackend/';
    $imagenes_path = $base_url . 'Capa_Presentacion/IMAGEN/';
    $iconos_path = $imagenes_path . 'iconos/';
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
?>


<div class="sidebar">
    <div class="sidebar-cabeza">
        <h2 id="toggleSidebar"><span>CineMax</span></h2>
        <?php if(isset($_SESSION['usuario'])): ?>
            <div>
                Hola, <?php echo $_SESSION['usuario']['nombre']; ?>
                <br>
                <small>Puntos: <?php echo $_SESSION['usuario']['puntos']; ?></small>
            </div>
        <?php endif; ?>
        
        
    </div>
    <ul class="sidebar-menu">
        <li><a href="<?= BASE_URL ?>index.php" class="seleccion_activa"><i><img class="ColorImg"  src="<?= $iconos_path ?>inicio.png" height="20px"></i><span>Inicio</span></a></li>
        <li><a href="<?= BASE_URL ?>Capa_Presentacion/PHP/Login-Usuarios/registro_usuario.php"><i ><img class="ColorImg"  src="<?= $iconos_path ?>ingresar.png" height="20px"></i><span>Registrarse</span></a></li>
        <li><a href="<?= BASE_URL ?>Capa_Presentacion/PHP/Login-Usuarios/login_usuario.php"><i><img class="ColorImg"  src="<?= $iconos_path ?>usuario.png" height="20px"></i><span>Iniciar Sesión</span></a></li>
        <li><a href="<?= BASE_URL ?>Capa_Presentacion/PHP/venta-transaccion/comprar.php"><i><img   src="<?= $iconos_path ?>Boleto.png" height="20px"></i><span>Compras</span></a></li>
        <li><a href="<?= BASE_URL ?>Capa_Presentacion/PHP/Login-Usuarios/perfil.php"><span>Perfil</span></a></li>
        <li><a href="<?= BASE_URL ?>Capa_Presentacion/PHP/Administracion/Sesion.php"><i><img class="ColorImg"  src="<?= $iconos_path ?>admin.png" height="20px"></i><span>Administrador</span></a></li>
        
    </ul>
</div>
<h2 id="toggleSidebar_2"><span>CineMax</span></h2>

<!-- ESTE SOLO ES UN EJEMPLO PARA REPLICAR EN LAS DEMAS PAGINAS  -->
<!-- <div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Sistema de cine</h1>
        <p>Bienvenido al sistema de compra de boletos de CineMax</p>
    </div>
    
    <div class="contenido-cuerpo">
        <h2>Contenido Principal</h2>
        aqui solo va un poco de texto y para llamarlo a los archivos php
        <code>include('sidebar.html');</code>
    </div>
</div> -->