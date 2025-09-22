<?php
include "../../../Capa_Negocio/Modulo-Administracion/Gestion_ComercialN.php";
$data = LogicaGC($conexion);
$peliculas = $data['peliculas'];
$proyecciones = $data['proyecciones'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Películas</title>
<link rel="stylesheet" href="../../CSS/Administracion/Gestion_ComercialC.css">
<script src="../../JAVASCRIPT/Administracion/Gestion_ComercialV.js"></script>
</head>
<body>
<?php include "../../HTML/Administracion/Navbar.html"; ?>
<form method="POST">
    <button type="submit" name="cerrarSesion">Cerrar Sesión</button>
</form>

<h2>Gestión de Películas</h2>

<h3>Agregar Película</h3>
<form method="POST" onsubmit="return ValidarP()">
    <input type="text" name="nom_pel" placeholder="Nombre Película" required>
    <input type="text" name="lenguaje" placeholder="Lenguaje">
    <select name="formato" required>
        <option value="">Formato</option>
        <option value="2D">2D</option>
        <option value="3D">3D</option>
        <option value="4D">4D</option>
    </select>
    <input type="text" name="categoria" placeholder="Categoría">
    <input type="date" name="fecha_lanzamiento">
    <input type="text" name="clasificacion" placeholder="Clasificación">
    <input type="text" name="sonido" placeholder="Sonido">
    <button type="submit" name="agregarPelicula">Agregar</button>
</form>

<h3>Lista de Películas</h3>
<table>
<tr>
<th>ID</th><th>Nombre</th><th>Lenguaje</th><th>Formato</th><th>Categoría</th><th>Fecha Lanzamiento</th><th>Clasificación</th><th>Sonido</th><th>Estado</th><th>Acciones</th>
</tr>
<?php while($p = $peliculas->fetch_assoc()): ?>
<tr>
<form method="POST">
    <td><?= $p['idPelicula'] ?><input type="hidden" name="idPelicula" value="<?= $p['idPelicula'] ?>"></td>
    <td><input type="text" name="nom_pel" value="<?= $p['nom_pel'] ?>" required></td>
    <td><input type="text" name="lenguaje" value="<?= $p['lenguaje'] ?>"></td>
    <td>
        <select name="formato" required>
            <option value="2D" <?= $p['formato']=='2D'?'selected':'' ?>>2D</option>
            <option value="3D" <?= $p['formato']=='3D'?'selected':'' ?>>3D</option>
            <option value="4D" <?= $p['formato']=='4D'?'selected':'' ?>>4D</option>
        </select>
    </td>
    <td><input type="text" name="categoria" value="<?= $p['categoria'] ?>"></td>
    <td><input type="date" name="fecha_lanzamiento" value="<?= $p['fecha_lanzamiento'] ?>"></td>
    <td><input type="text" name="clasificacion" value="<?= $p['clasificacion'] ?>"></td>
    <td><input type="text" name="sonido" value="<?= $p['sonido'] ?>"></td>
    <td>
        <select name="estado" required>
            <option value="En proyección" <?= $p['estado']=='En proyección'?'selected':'' ?>>En proyección</option>
            <option value="Desactivado" <?= $p['estado']=='Desactivado'?'selected':'' ?>>Desactivado</option>
        </select>
    </td>
    <td><button type="submit" name="modificarPelicula">Guardar</button></td>
</form>
</tr>
<?php endwhile; ?>
</table>


<h3>Agregar / Modificar Proyección</h3>
<form method="POST" onsubmit="return ValidarPro()">
    <input type="number" name="idPelicula" placeholder="ID Película" required>
    <input type="number" name="nro_Sala" placeholder="Número de Sala" required>
    <input type="date" name="fecha" required>
    <input type="time" name="hora" required>
    <button type="submit" name="agregarProyeccion">Agregar</button>
</form>

<h3>Lista de Proyecciones</h3>
<table>
<tr>
<th>ID</th><th>ID Película</th><th>Nro Sala</th><th>Fecha</th><th>Hora</th><th>Acciones</th>
</tr>
<?php while($sp = $proyecciones->fetch_assoc()): ?>
<?php if($sp['fecha'] != '0000-00-00'): ?>
<tr>
<form method="POST">
    <td><?= $sp['idProyeccion'] ?><input type="hidden" name="idProyeccion" value="<?= $sp['idProyeccion'] ?>"></td>
    <td><input type="number" name="idPelicula" value="<?= $sp['idPelicula'] ?>" required></td>
    <td><input type="number" name="nro_Sala" value="<?= $sp['nro_Sala'] ?>" required></td>
    <td><input type="date" name="fecha" value="<?= $sp['fecha'] ?>" required></td>
    <td><input type="time" name="hora" value="<?= $sp['hora'] ?>" required></td>
    <td>
        <button type="submit" name="modificarProyeccion">Guardar</button>
        <button type="submit" name="eliminarProyeccion">Eliminar</button>
    </td>
</form>
</tr>
<?php endif; ?>
<?php endwhile; ?>
</table>

</body>
</html>
