<?php
session_start();
include "../../../Capa_Datos/conexionBd/conexion.php";

function registrarUsuario($conexion, $datos) {
    $sql = "INSERT INTO 
    USUARIO (nom_usu, nombre, rol, puntos, fec_creacion, fec_nac, telefono, ci_nit,fecha_acceso,contrasena) 
    VALUES (?, ?, 'Cliente', 0, CURDATE(), ?, ?, ?,CURDATE(),?)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", 
        $datos['nom_usu'], 
        $datos['nombre'], 
        $datos['fec_nac'], 
        $datos['telefono'], 
        $datos['ci_nit'],
        $datos['contrasena']
    );
    
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos = [
        'nom_usu' => $_POST['nom_usu'] ?? '',
        'nombre' => $_POST['nombre'] ?? '',
        'fec_nac' => $_POST['fec_nac'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'ci_nit' => $_POST['ci_nit'] ?? '',
        'contrasena' => $_POST['contrasena'] ?? ''
    ];
    
    // Validar que todos los campos estén completos
    if (array_filter($datos)) {
        if (registrarUsuario($conexion, $datos)) {
            header("Location: login_usuario.php?registro=exitoso");
            exit();
        } else {
            $error = "Error al registrar usuario";
        }
    } else {
        $error = "Complete todos los campos";
    }
}
?>
