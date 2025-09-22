<?php
include "../../../Capa_Datos/conexionBd/conexion.php";
function Listar($conexion){
    $sql = "SELECT h.idMantenimiento, s.nro_Sala, s.capacidad, h.fechaMantenimiento 
            FROM hist_mantenimiento h
            JOIN SALA s ON h.nro_Sala = s.nro_Sala
            WHERE h.fechaMantenimiento != '0000-00-00'
            ORDER BY h.idMantenimiento DESC";
    return $conexion->query($sql);
}

function Agregar($conexion, $nro_Sala, $fecha){
    $stmt = $conexion->prepare("INSERT INTO hist_mantenimiento(nro_Sala, fechaMantenimiento) VALUES(?, ?)");
    $stmt->bind_param("is", $nro_Sala, $fecha);
    $stmt->execute();
    $stmt->close();
}
if(isset($_POST['cerrarSesion'])){
    session_unset();
    session_destroy();
    header("Location: Sesion.php");
    exit();
}
function LogicaM($conexion){
    global $mensaje;
    if(isset($_POST['agregar'])){
        $nro_Sala = $_POST['nro_Sala'] ?? 0;
        $fecha = $_POST['fecha'] ?? '';
        $existe =-1;
        if($nro_Sala > 0 && $fecha != ''){
            $stmt = $conexion->prepare("SELECT COUNT(*) FROM sala WHERE nro_Sala = ?");
            $stmt->bind_param("i", $nro_Sala);
            $stmt->execute();
            $stmt->bind_result($existe);
            $stmt->fetch();
            $stmt->close();

            if($existe > 0){
                Agregar($conexion, $nro_Sala, $fecha);
                $mensaje = "Mantenimiento agregado correctamente";
            } else {
                $mensaje = "La sala no existe";
            }
        } else {
            $mensaje = "Complete todos los campos";
        }
    }
}



?>
