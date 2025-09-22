<?php
include "../../../Capa_Datos/conexionBd/conexion.php";
function Sesion($conexion, $idPersonal, $ci){
    $sql = "SELECT * FROM PERSONAL WHERE idPersonal=? AND ci=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $idPersonal, $ci);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){
        return $resultado->fetch_assoc();
    } else {
        return false; 
    }
}


function LogicaS($conexion){
    session_start();
    $mensaje = "";

    if(isset($_POST['login'])){
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        if($usuario && $password){
            $personal = Sesion($conexion, $usuario, $password);

            if($personal){
                $_SESSION['idPersonal'] = $personal['idPersonal'];
                $_SESSION['nombre'] = $personal['nombre'];
                $_SESSION['puesto'] = $personal['puesto'];

                switch($personal['puesto']){
                    case 'Recursos Humanos':
                        header("Location: Personal.php");
                        exit();
                    case 'Gestión Comercial':
                        header("Location: Pelicula.php");
                        exit();
                    case 'Gestión de Salas':
                        header("Location: Mantenimiento_Salas.php");
                        exit();
                    default:
                        header("Location: Pelicula.php");
                        exit();
                }
            } else {
                $mensaje = "Usuario o contraseña incorrectos";
            }
        } else {
            $mensaje = "Complete todos los campos";
        }
    }

    return $mensaje;
}
?>
