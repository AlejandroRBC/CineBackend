<?php
    include "../../../Capa_Negocio/Modulo-Usuario/login.php";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Usuario - CineMax</title>
    <link rel="stylesheet" href="../../CSS/Administracion/SesionC.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión - Cliente</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="text" name="nom_usu" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            ¿No tienes cuenta? <a href="registro_usuario.php">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>