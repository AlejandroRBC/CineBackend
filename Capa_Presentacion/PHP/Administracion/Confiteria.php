<?php
include "../../../Capa_Negocio/Modulo-Administracion/Gestion_ComercialN.php";
$data = LogicaPC($conexion);
$productos = $data['productos'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Confitería</title>
<link rel="stylesheet" href="../../CSS/Administracion/Gestion_ComercialC.css">
<script src="../../JAVASCRIPT/Administracion/Gestion_ComercialV.js"></script>
</head>
<body>
<?php include "../../HTML/Administracion/Navbar.html"; ?>

<form method="POST">
    <button type="submit" name="cerrarSesion">Cerrar Sesión</button>
</form>

<h2>Gestión de Confitería</h2>

<h3>Agregar Producto</h3>
<form method="POST" onsubmit="return validarPro()">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="text" name="descripcion" placeholder="Descripción">
    <input type="number" name="stock" placeholder="Stock" required>
    <select name="es_combo" required>
        <option value="False">No</option>
        <option value="True">Sí</option>
    </select>
    <button type="submit" name="agregarProducto">Agregar</button>
</form>

<h3>Lista de Productos</h3>
<table>
<tr>
<th>ID</th><th>Nombre</th><th>Precio</th><th>Descripción</th><th>Stock</th><th>Es Combo</th><th>Activo</th><th>Acciones</th>
</tr>
<?php while($p = $productos->fetch_assoc()): ?>
<tr>
<form method="POST">
    <td><?= $p['idProducto'] ?><input type="hidden" name="idProducto" value="<?= $p['idProducto'] ?>"></td>
    <td><input type="text" name="nombre" value="<?= $p['nombre'] ?>" required></td>
    <td><input type="number" step="0.01" name="precio" value="<?= $p['precio'] ?>" required></td>
    <td><input type="text" name="descripcion" value="<?= $p['descripcion'] ?>"></td>
    <td><input type="number" name="stock" value="<?= $p['stock'] ?>" required></td>
    <td>
        <select name="es_combo">
            <option value="False" <?= $p['es_combo']=='False'?'selected':'' ?>>No</option>
            <option value="True" <?= $p['es_combo']=='True'?'selected':'' ?>>Sí</option>
        </select>
    </td>
    <td>
        <select name="activo" required>
            <option value="Activo" <?= $p['activo']=='Activo'?'selected':'' ?>>Activo</option>
            <option value="Desactivado" <?= $p['activo']=='Desactivado'?'selected':'' ?>>Desactivado</option>
        </select>
    </td>
    <td>
        <button type="submit" name="modificarProducto">Guardar</button>
        <button type="submit" name="eliminarProducto">Eliminar</button>
    </td>
</form>

</tr>
<?php endwhile; ?>
</table>

</body>
</html>
