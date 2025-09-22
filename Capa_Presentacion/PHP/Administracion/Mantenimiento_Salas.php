<?php
include "../../../Capa_Negocio/Modulo-Administracion/Man_SalasN.php";

LogicaM($conexion);
$mantenimientos = Listar($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mantenimiento de Salas</title>
<link rel="stylesheet" href="../../CSS/Administracion/Man_SalasC.css">
<script src="../../JAVASCRIPT/Administracion/Man_SalasV.js"></script>
</head>
<body>

<?php if(isset($mensaje)) echo "<p>$mensaje</p>"; ?>

<form method="POST">
    <button type="submit" name="cerrarSesion">Cerrar Sesión</button>
</form>

<h2>Mantenimiento de Salas</h2>

<h3>Agregar Mantenimiento</h3>
<form method="POST" onsubmit="return Validar()">
    <input type="number" name="nro_Sala" placeholder="Nro Sala" required>
    <input type="date" name="fecha" required>
    <button type="submit" name="agregar">Agregar</button>
</form>

<h3>Lista de Mantenimientos</h3>
<table>
<tr>
    <th>ID</th>
    <th>Nro Sala</th>
    <th>Capacidad Sala</th>
    <th>Fecha</th>
</tr>
<?php while($m = $mantenimientos->fetch_assoc()): ?>
<tr>
    <td><?= $m['idMantenimiento'] ?></td>
    <td><?= $m['nro_Sala'] ?></td>
    <td><?= $m['capacidad'] ?></td>
    <td><?= $m['fechaMantenimiento'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
