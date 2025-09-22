<?php
include "../../../Capa_Negocio/Modulo-Administracion/PersonalN.php";

$resultados = LogicaP($conexion);
$personal = $resultados['personal'];
$historial = $resultados['historial'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Administrar Personal</title>
<link rel="stylesheet" href="../../CSS/Administracion/PersonalC.css">
<script src="../../JAVASCRIPT/Administracion/PersonalV.js"></script>
</head>
<body>
<form method="POST">
    <button type="submit" name="cerrarSesion">Cerrar Sesión</button>
</form>

<h2>Administración de Personal</h2>

<h3>Agregar Personal</h3>
<form method="POST" onsubmit="return ValidarP()">
    <input type="text" name="ci" placeholder="CI" required>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="puesto" placeholder="Puesto" required>
    <select name="turno" required>
        <option value="Tiempo Completo">Tiempo Completo</option>
        <option value="Medio Tiempo">Medio Tiempo</option>
        <option value="Fines de Semana">Fines de Semana</option>
    </select>
    <input type="number" step="0.01" name="salario" placeholder="Salario" required>
    <button type="submit" name="agregar">Agregar</button>
</form>

<h3>Lista de Personal</h3>
<table>
<tr>
<th>ID</th><th>CI</th><th>Nombre</th><th>Puesto</th><th>Turno</th><th>Salario</th><th>Acciones</th>
</tr>
<?php while($fila = $personal->fetch_assoc()): ?>
<?php if($fila['puesto'] != '0'): ?>
<tr>
<form method="POST">
    <td><?= $fila['idPersonal'] ?><input type="hidden" name="idPersonal" value="<?= $fila['idPersonal'] ?>"></td>
    <td><input type="text" name="ci" value="<?= $fila['ci'] ?>" required></td>
    <td><input type="text" name="nombre" value="<?= $fila['nombre'] ?>" required></td>
    <td><input type="text" name="puesto" value="<?= $fila['puesto'] ?>" required></td>
    <td>
        <select name="turno" required>
            <option value="Tiempo Completo" <?= $fila['turno']=='Tiempo Completo'?'selected':'' ?>>Tiempo Completo</option>
            <option value="Medio Tiempo" <?= $fila['turno']=='Medio Tiempo'?'selected':'' ?>>Medio Tiempo</option>
            <option value="Fines de Semana" <?= $fila['turno']=='Fines de Semana'?'selected':'' ?>>Fines de Semana</option>
        </select>
    </td>
    <td><input type="number" step="0.01" name="salario" value="<?= $fila['salario'] ?>" required></td>
    <td>
        <button type="submit" name="modificar">Guardar</button>
        <button type="submit" name="eliminar">Eliminar</button>
    </td>
</form>
</tr>
<?php endif; ?>
<?php endwhile; ?>
</table>

<h3>Registrar Asistencia</h3>
<form method="POST" onsubmit="return ValidarA()">
    <input type="number" name="idPersonal" placeholder="ID Personal" required>
    <input type="time" name="horaEntrada" required>
    <input type="time" name="horaSalida" required>
    <input type="date" name="fecha" required>
    <button type="submit" name="asistencia">Registrar</button>
</form>

<h3>Buscar Historial</h3>
<form method="POST" onsubmit="return ValidarB()">
    <input type="number" name="idBuscar" placeholder="ID Personal" required>
    <button type="submit" name="buscar">Buscar</button>
</form>

<?php if(!empty($historial)): ?>
<h3>Historial de Asistencia</h3>
<table>
<tr><th>CI</th><th>Nombre</th><th>Fecha</th><th>Entrada</th><th>Salida</th></tr>
<?php foreach($historial as $h): ?>
<tr>
    <td><?= $h['ci'] ?></td>
    <td><?= $h['nombre'] ?></td>
    <td><?= $h['fecha'] ?></td>
    <td><?= $h['horaEntrada'] ?></td>
    <td><?= $h['horaSalida'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</body>
</html>
