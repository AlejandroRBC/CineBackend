<?php

include "../../../Capa_Datos/conexionBd/conexion.php";

function ListarP($conexion){
    $sql = "SELECT * FROM PERSONAL WHERE puesto!='0'";
    return $conexion->query($sql);
}

function AgregarP($conexion, $ci, $nombre, $puesto, $turno, $salario){
    $sql = "INSERT INTO PERSONAL (ci, nombre, puesto, turno, salario) VALUES (?,?,?,?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssd", $ci, $nombre, $puesto, $turno, $salario);
    return $stmt->execute();
}

function ModificarP($conexion, $id, $ci, $nombre, $puesto, $turno, $salario){
    $sql = "UPDATE PERSONAL SET ci=?, nombre=?, puesto=?, turno=?, salario=? WHERE idPersonal=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssdi", $ci, $nombre, $puesto, $turno, $salario, $id);
    return $stmt->execute();
}

function EliminarP($conexion, $id){
    $sql = "UPDATE PERSONAL SET puesto='0' WHERE idPersonal=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function RegistrarA($conexion, $id, $entrada, $salida, $fecha){
    $sql = "INSERT INTO Hist_Entrada_personal (idPersonal, horaEntrada, horaSalida, fecha) VALUES (?,?,?,?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isss", $id, $entrada, $salida, $fecha);
    return $stmt->execute();
}

function BuscarA($conexion, $idPersonal){
    $sql = "SELECT h.fecha, h.horaEntrada, h.horaSalida, p.nombre, p.ci
            FROM Hist_Entrada_personal h
            JOIN PERSONAL p ON h.idPersonal = p.idPersonal
            WHERE h.idPersonal = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPersonal);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $historial = [];
    while($row = $resultado->fetch_assoc()){
        $historial[] = $row;
    }
    return $historial;
}
function LogicaP($conexion){
    session_start();

    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();
        header("Location: Sesion.php");
        exit();
    }

    if(isset($_POST['agregar'])){
        $ci = $_POST['ci'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $puesto = $_POST['puesto'] ?? '';
        $turno = $_POST['turno'] ?? '';
        $salario = $_POST['salario'] ?? 0;

        if($ci && $nombre && $puesto && $turno && $salario > 0){
            AgregarP($conexion, $ci, $nombre, $puesto, $turno, $salario);
        }
    }

    if(isset($_POST['modificar'])){
        $id = $_POST['idPersonal'] ?? 0;
        $ci = $_POST['ci'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $puesto = $_POST['puesto'] ?? '';
        $turno = $_POST['turno'] ?? '';
        $salario = $_POST['salario'] ?? 0;

        if($id && $ci && $nombre && $puesto && $turno && $salario > 0){
            ModificarP($conexion, $id, $ci, $nombre, $puesto, $turno, $salario);
        }
    }

    if(isset($_POST['eliminar'])){
        $id = $_POST['idPersonal'] ?? 0;
        if($id) EliminarP($conexion, $id);
    }

    if(isset($_POST['asistencia'])){
        $id = $_POST['idPersonal'] ?? 0;
        $entrada = $_POST['horaEntrada'] ?? '';
        $salida = $_POST['horaSalida'] ?? '';
        $fecha = $_POST['fecha'] ?? '';

        if($id && $entrada && $salida && $fecha){
            RegistrarA($conexion, $id, $entrada, $salida, $fecha);
        }
    }

    $historial = [];
    if(isset($_POST['buscar'])){
        $id = $_POST['idBuscar'] ?? 0;
        if($id){
            $historial = BuscarA($conexion, $id);
        }
    }

    $personal = ListarP($conexion);

    return ['personal' => $personal, 'historial' => $historial];
}
?>

