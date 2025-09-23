<?php
session_start();
include "../../../Capa_Datos/conexionBd/conexion.php";

function verificarUsuario($conexion, $nom_usu, $password) {
    $sql = "SELECT * FROM USUARIO WHERE nom_usu = ? AND ci_nit = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nom_usu, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_usu = $_POST['nom_usu'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($nom_usu && $password) {
        $usuario = verificarUsuario($conexion, $nom_usu, $password);
        
        if ($usuario) {
            $_SESSION['usuario'] = [
                'id' => $usuario['idUsuario'],
                'nombre' => $usuario['nombre'],
                'nom_usu' => $usuario['nom_usu'],
                'rol' => $usuario['rol'],
                'puntos' => $usuario['puntos']
            ];
            
            // Inicializar carrito vacío
            $_SESSION['carrito'] = [
                'boletos' => [],
                'productos' => [],
                'total' => 0
            ];
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        $error = "Complete todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Usuario - CineMax</title>
    <link rel="stylesheet" href="../CSS/Sidebar/sidebar.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #3182ce;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión - Cliente</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="text" name="nom_usu" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña (CI/NIT)" required>
            <button type="submit">Ingresar</button>
        </form>
        
        <p style="text-align: center; margin-top: 15px;">
            ¿No tienes cuenta? <a href="registro_usuario.php">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>