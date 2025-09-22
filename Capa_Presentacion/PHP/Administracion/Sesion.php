<?php
include "../../../Capa_Negocio/Modulo-Administracion/SesionN.php";

$error = LogicaS($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Cine</title>
    <link rel="stylesheet" href="../../CSS/Administracion/SesionC.css">
    <script src="../../JAVASCRIPT/Administracion/SesionV.js"></script>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" onsubmit="return ValidarS()">
            <label for="usuario">Usuario (ID):</label>
            <input type="number" id="usuario" name="usuario" required>

            <label for="password">Contraseña (CI):</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Ingresar</button>
        </form>
    </div>
</body>
</html>
