<link rel="stylesheet" href="../../CSS/Sidebar/sidebar.css">
<link rel="stylesheet" href="../../CSS/Venta-Transaccion/tablas.css">
<link rel="stylesheet" href="../../CSS/Venta-Transaccion/botones.css">
<script src="../../JAVASCRIPT/Sidebar/sidebar.js"></script>

<?php
    define("BASE_URL", "/CineBackend/"); 
    include('../../HTML/Sidebar/sidebar.php');
    include_once __DIR__ . "/../../../Capa_Datos/conexionBD/conexion.php";
    include_once __DIR__ . "/../../../Capa_Datos/SQL/CRUDPeliculas.php";
    $peliculas = ListarPeliculasHabilitadas($conexion);
?>

<div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Sistema de cine</h1>
    </div>
    
    <div class="contenido-cuerpo">
        <h2>Peliculas</h2>
        <div class="card"> 
        <button type="button" class="dismiss">X</button> 
        <div class="header"> 
            <div class="content">
                <span class="title">Order validated</span> 
                <p class="message">Thank you for your purchase. you package will be delivered within 2 days of your purchase</p> 
                </div> 
                    <div class="actions">
                        <button type="button" class="history">History</button> 
                        <button type="button" class="track">Track my package</button> 
                    </div> 
                </div> 
            </div>
    </div>
</div>