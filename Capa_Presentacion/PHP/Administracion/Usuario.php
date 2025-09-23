<?php
include "../../../Capa_Negocio/Modulo-Administracion/UsuarioN.php";

$resultados = LogicaU($conexion);
$usuarios = $resultados['usuarios'];
$historial = $resultados['historial'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Administrar Usuarios</title>
<link rel="stylesheet" href="../../CSS/Administracion/PersonalC.css">
</head>
<body>
<form method="POST">
    <button type="submit" name="cerrarSesion">Cerrar Sesión</button>
</form>

<h2>Administración de Usuarios</h2>

<h3>Lista de Usuarios</h3>
<table>
<tr>
<th>ID</th><th>Usuario</th><th>Nombre</th><th>Rol</th><th>Puntos</th><th>Teléfono</th><th>CI/NIT</th><th>Contraseña</th><th>Acciones</th>
</tr>
<?php while($fila = $usuarios->fetch_assoc()): ?>
<?php if($fila['rol'] != '0'): ?>
<tr>
<form method="POST">
    <td><?= $fila['idUsuario'] ?><input type="hidden" name="idUsuario" value="<?= $fila['idUsuario'] ?>"></td>
    <td><input type="text" name="nom_usu" value="<?= $fila['nom_usu'] ?>" required></td>
    <td><input type="text" name="nombre" value="<?= $fila['nombre'] ?>" required></td>
    <td><input type="text" name="rol" value="<?= $fila['rol'] ?>" required></td>
    <td><input type="number" name="puntos" value="<?= $fila['puntos'] ?>"></td>
    <td><input type="text" name="telefono" value="<?= $fila['telefono'] ?>"></td>
    <td><input type="text" name="ci_nit" value="<?= $fila['ci_nit'] ?>"></td>
    <td><input type="text" name="contrasena" value="<?= $fila['contrasena'] ?>" required></td>
    <td>
        <button type="submit" name="modificar">Guardar</button>
        <button type="submit" name="eliminar">Eliminar</button>
    </td>
</form>
</tr>
<?php endif; ?>
<?php endwhile; ?>
</table>

<h3>Buscar Historial de Usuario</h3>
<form method="POST">
    <input type="number" name="idBuscar" placeholder="ID Usuario" required>
    <button type="submit" name="buscar">Buscar</button>
</form>

<?php if(!empty($historial)): ?>
<h3>Último Acceso</h3>
<p><?= $historial['ultimo_acceso']['fecha_acceso'] ?? 'No registrado' ?></p>

<h3>Historial de Transacciones</h3>
<?php foreach($historial['ventas'] as $venta): ?>
<table>
<tr>
<th colspan="5">Venta ID: <?= $venta['idVenta'] ?> | Fecha: <?= $venta['fecha'] ?> | Total: <?= $venta['total'] ?> | Tipo Pago: <?= $venta['tipo_pago'] ?></th>
</tr>
<tr><th>Tipo</th><th>Nombre</th><th>Confiteria / Butaca</th><th>Subtotal</th><th>Sala</th></tr>
<?php foreach($venta['productos'] as $prod): ?>
<tr>
    <td>Producto</td>
    <td><?= $prod['producto'] ?></td>
    <td><?= $prod['cantidad'] ?></td>
    <td><?= $prod['subtotal'] ?></td>
    <td>-</td>
</tr>
<?php endforeach; ?>
<?php foreach($venta['peliculas'] as $pel): ?>
<tr>
    <td>Película</td>
    <td><?= $pel['nom_pel'] ?></td>
    <td>Fila <?= $pel['nro_Fila'] ?> Col <?= $pel['nro_Col'] ?></td>
    <td><?= $pel['subtotal'] ?></td>
    <td><?= $pel['nro_Sala'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<br>
<?php endforeach; ?>
<?php endif; ?>
</body>
</html>
