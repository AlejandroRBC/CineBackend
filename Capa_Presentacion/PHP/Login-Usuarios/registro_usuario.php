<?php
    include "../../../Capa_Negocio/Modulo-Usuario/Registro.php";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - CineMax</title>
    <link rel="stylesheet" href="../../CSS/Administracion/SesionC.css">
</head>
<body>
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="text" name="nom_usu" placeholder="Nombre de usuario" required>
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="date" name="fec_nac" placeholder="Fecha de nacimiento" required>
            <input type="tel" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="ci_nit" placeholder="CI o NIT" required>
            <input type="text" name="contrasena" placeholder="Define tu Contraseña" required>
            
            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>