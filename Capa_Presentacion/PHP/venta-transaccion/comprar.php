<link rel="stylesheet" href="../../CSS/Sidebar/sidebar.css">
<link rel="stylesheet" href="../../CSS/Venta-Transaccion/tablas.css">
<link rel="stylesheet" href="../../CSS/Venta-Transaccion/botones.css">
<link rel="stylesheet" href="../../CSS/Venta-Transaccion/footer.css">
<script src="../../JAVASCRIPT/Sidebar/sidebar.js"></script>
<script src="../../JAVASCRIPT/venta-transaccion/carrito.js"></script>

<?php
    define("BASE_URL", "/CineBackend/"); 
    include('../../PHP/Sidebar/sidebar.php');
    include_once __DIR__ . "/../../../Capa_Datos/conexionBD/conexion.php";
    include_once __DIR__ . "/../../../Capa_Datos/SQL/CRUDPeliculas.php";
    include_once __DIR__ . "/../../../Capa_Datos/SQL/CRUDProductos.php";
    $peliculas = ListarPeliculasHabilitadas($conexion);
    $productos = ListarProductosDisponibles($conexion);
?>
<div class="contenido-principal">
    <div class="content-cabeza">
        <h1>Compra de Boletos</h1>
        <p>Elige la película, algo del candybar y termina la compra</p>
    </div>
    <div class="contenido-cuerpo">
        <h4>Escoge la película</h4>
        <table >
            <tr>
                <th>ID</th><th>Nombre</th><th>Lenguaje</th><th>Formato</th>
                <th>Categoría</th><th>Fecha Lanzamiento</th>
                <th>Clasificación</th><th>Sonido</th>
            </tr>
            <?php while($p = $peliculas->fetch_assoc()): ?>
                <tr>
                    <td><?= $p['idPelicula'] ?></td>
                    <td><?= $p['nom_pel'] ?></td>
                    <td><?= $p['lenguaje'] ?></td>
                    <td><?= $p['formato'] ?></td>
                    <td><?= $p['categoria'] ?></td>
                    <td><?= $p['fecha_lanzamiento'] ?></td>
                    <td><?= $p['clasificacion'] ?></td>
                    <td><?= $p['sonido'] ?></td>
                    <td><button type="button"
                        data-tipo="pelicula"
                        data-id="<?= $p['idPelicula'] ?>"
                        data-nombre="<?= $p['nom_pel'] ?>"
                        data-precio="35">Agregar Al carrito</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div class="contenido-cuerpo">
        <h4>Acompaña tu película</h4>
        <table >
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>descripcion</th>
            </tr>
            <?php while($pr = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?= $pr['idProducto'] ?></td>
                    <td><?= $pr['nombre'] ?></td>
                    <td><?= $pr['precio'] ?></td>
                    <td><?= $pr['descripcion'] ?></td>
                    <td><button type="button"
                            data-tipo="producto"
                            data-id="<?= $pr['idProducto'] ?>"
                            data-nombre="<?= $pr['nombre'] ?>"
                            data-precio="<?= $pr['precio'] ?>">Agregar Al carrito</button>
                    </td>

                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div class="contenido-cuerpo">
        <h3>Carrito</h3>
    <form method="POST" action="../../../Capa_Negocio/Modulo-Venta-Transaccion/procesar_compra.php">
        <table id="tabla-carrito" >
            <tr>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Asiento (solo películas)</th>
                <th></th>
            </tr>
        </table>

        <div class="modalPago" id="modalPago">
            <select required name="metodoPago" id="metodoPago">
                <option value="" disabled selected>Metodo de Pago</option>
                <option value="QR">Q.R.</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia">Transferencia</option>
            </select>
        </div>
        <button type="submit" name="finalizar">Finalizar Compra</button>
    </form>
    </div>
    <div class="contenido-cuerpo">
        <?php include('../../HTML/Venta-Transaccion/footer.html'); ?>
    </div>

</div>
