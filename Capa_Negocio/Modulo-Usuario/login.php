<?php
    session_start();
    include "../../../Capa_Datos/conexionBd/conexion.php";
    function verificarUsuario($conexion, $nom_usu, $password) {
        $sql = "SELECT * FROM USUARIO WHERE nom_usu = ? AND contrasena = ?";
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
                
                $_SESSION['carrito'] = [
                    'boletos' => [],
                    'productos' => [],
                    'total' => 0
                ];
                
                header("Location: ../../../index.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            $error = "Complete todos los campos";
        }
    }

?>