<?php
include "../../../Capa_Datos/conexionBd/conexion.php";

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])){
    header("Location: login_usuario.php");
    exit();
}

$idUsuario = $_SESSION['usuario']['id'];

function ObtenerUsuario($conexion, $idUsuario){
    $stmt = $conexion->prepare("SELECT * FROM USUARIO WHERE idUsuario=?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $usuario = $res->fetch_assoc();
    $stmt->close();
    return $usuario;
}

function EliminarCuenta($conexion, $idUsuario){
    $stmt = $conexion->prepare("UPDATE USUARIO SET rol='0' WHERE idUsuario=?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->close();
}


function ModificarUsuario($conexion, $idUsuario, $nom_usu, $nombre, $telefono, $ci_nit, $contrasena){
    $stmt = $conexion->prepare("UPDATE USUARIO SET nom_usu=?, nombre=?, telefono=?, ci_nit=?, contrasena=? WHERE idUsuario=?");
    $stmt->bind_param("sssssi", $nom_usu, $nombre, $telefono, $ci_nit, $contrasena, $idUsuario);
    $stmt->execute();
    $stmt->close();

    $_SESSION['usuario']['nom_usu'] = $nom_usu;
    $_SESSION['usuario']['nombre'] = $nombre;
}

function LogicaPerfil($conexion){
    global $idUsuario;

    if(isset($_POST['borrar_cuenta'])){
        EliminarCuenta($conexion, $idUsuario);
        session_destroy();
        header("Location: login_usuario.php");
        exit();
    }

    if(isset($_POST['modificar'])){
        $nom_usu = $_POST['nom_usu'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $ci_nit = $_POST['ci_nit'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        ModificarUsuario($conexion, $idUsuario, $nom_usu, $nombre, $telefono, $ci_nit, $contrasena);

        header("Location: perfil.php");
        exit();
    }

    return ObtenerUsuario($conexion, $idUsuario);
}
?>
