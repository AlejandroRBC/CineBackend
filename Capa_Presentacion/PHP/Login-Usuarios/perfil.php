<?php
include "../../../Capa_Negocio/Modulo-Usuario/perfilN.php";

$usuario = LogicaPerfil($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Perfil de Usuario</title>
<link rel="stylesheet" href="../../CSS/LoginUsuario/perfil.css">

</head>
<body>

<h1>Perfil de Usuario</h1>
<p>Gestiona tu información de cuenta</p>

<h2>Información</h2>
<form method="POST">
<table>
<tr><th>Campo</th><th>Valor</th></tr>
<tr><td>Nombre de usuario:</td><td><input type="text" name="nom_usu" value="<?= htmlspecialchars($usuario['nom_usu']) ?>" required></td></tr>
<tr><td>Nombre:</td><td><input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required></td></tr>
<tr><td>Rol:</td><td><?= htmlspecialchars($usuario['rol']) ?></td></tr>
<tr><td>Puntos:</td><td><?= htmlspecialchars($usuario['puntos']) ?></td></tr>
<tr><td>Teléfono:</td><td><input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"></td></tr>
<tr><td>CI/NIT:</td><td><input type="text" name="ci_nit" value="<?= htmlspecialchars($usuario['ci_nit'] ?? '') ?>"></td></tr>
<tr><td>Contraseña:</td><td><input type="text" name="contrasena" value="<?= htmlspecialchars($usuario['contrasena'] ?? '') ?>" required></td></tr>
</table>

<br>
<button type="submit" name="modificar">Guardar cambios</button>
</form>

<br>
<form method="POST" onsubmit="return confirm('¿Seguro que quieres borrar tu cuenta?');">
    <button type="submit" name="borrar_cuenta">Borrar cuenta</button>
</form>

</body>
</html>
