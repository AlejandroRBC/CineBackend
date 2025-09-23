<?php
include "../../../Capa_Datos/conexionBd/conexion.php";

function ListarU($conexion){
    $sql = "SELECT * FROM USUARIO WHERE rol!='0'";
    return $conexion->query($sql);
}

function ModificarU($conexion, $idUsuario, $nom_usu, $nombre, $rol, $puntos, $fec_creacion, $fec_nac, $telefono, $ci_nit, $contrasena){
    $sql = "UPDATE USUARIO SET nom_usu=?, nombre=?, rol=?, puntos=?, fec_creacion=?, fec_nac=?, telefono=?, ci_nit=?, contrasena=? WHERE idUsuario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssisssssi", $nom_usu, $nombre, $rol, $puntos, $fec_creacion, $fec_nac, $telefono, $ci_nit, $contrasena, $idUsuario);
    return $stmt->execute();
}

function EliminarU($conexion, $idUsuario){
    $sql = "UPDATE USUARIO SET rol='0' WHERE idUsuario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    return $stmt->execute();
}
function InactividadU($conexion, $dias = 60){
    $sql = "UPDATE USUARIO 
            SET rol='0' 
            WHERE fecha_acceso IS NOT NULL 
            AND fecha_acceso <= DATE_SUB(NOW(), INTERVAL ? DAY)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $dias);
    $stmt->execute();
    $stmt->close();
}


function HistorialA($conexion, $idUsuario){
    $stmt1 = $conexion->prepare("SELECT fecha_acceso FROM USUARIO WHERE idUsuario=?");
    $stmt1->bind_param("i", $idUsuario);
    $stmt1->execute();
    $res1 = $stmt1->get_result();
    $ultimo_acceso = $res1->fetch_assoc();
    $stmt1->close();

    $stmt2 = $conexion->prepare("SELECT v.idVenta, v.total, v.tipo_pago, v.fecha FROM VENTA v WHERE v.idUsuario=?");
    $stmt2->bind_param("i", $idUsuario);
    $stmt2->execute();
    $resVentas = $stmt2->get_result();
    $ventas = [];
    while($venta = $resVentas->fetch_assoc()){
        $idVenta = $venta['idVenta'];

        $stmtProd = $conexion->prepare("SELECT p.nombre AS producto, dp.cantidad, dp.subtotal FROM Detalle_prods dp JOIN PRODUCTOS p ON dp.idProducto = p.idProducto WHERE dp.idVenta=?");
        $stmtProd->bind_param("i", $idVenta);
        $stmtProd->execute();
        $resProd = $stmtProd->get_result();
        $productos = [];
        while($prod = $resProd->fetch_assoc()){
            $productos[] = $prod;
        }
        $stmtProd->close();

        $stmtPel = $conexion->prepare("SELECT pel.nom_pel, dv.subtotal, b.nro_Fila, b.nro_Col, s.nro_Sala FROM Detalle_venta dv JOIN PELICULA pel ON dv.idPelicula = pel.idPelicula JOIN BUTACA b ON dv.idButaca = b.idButaca JOIN SALA s ON dv.nro_Sala = s.nro_Sala WHERE dv.idVenta=?");
        $stmtPel->bind_param("i", $idVenta);
        $stmtPel->execute();
        $resPel = $stmtPel->get_result();
        $peliculas = [];
        while($pel = $resPel->fetch_assoc()){
            $peliculas[] = $pel;
        }
        $stmtPel->close();

        $venta['productos'] = $productos;
        $venta['peliculas'] = $peliculas;
        $ventas[] = $venta;
    }
    $stmt2->close();

    return ['ultimo_acceso'=>$ultimo_acceso, 'ventas'=>$ventas];
}

function LogicaU($conexion){
    session_start();

    InactividadU($conexion, 365);

    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();
        header("Location: Sesion.php");
        exit();
    }

    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();
        header("Location: Sesion.php");
        exit();
    }

    if(isset($_POST['modificar'])){
        $id = $_POST['idUsuario'] ?? 0;
        $nom_usu = $_POST['nom_usu'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $rol = $_POST['rol'] ?? '';
        $puntos = $_POST['puntos'] ?? 0;
        $fec_creacion = $_POST['fec_creacion'] ?? '';
        $fec_nac = $_POST['fec_nac'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $ci_nit = $_POST['ci_nit'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        if($id && $nom_usu && $nombre && $rol){
            ModificarU($conexion, $id, $nom_usu, $nombre, $rol, $puntos, $fec_creacion, $fec_nac, $telefono, $ci_nit, $contrasena);
        }
    }

    if(isset($_POST['eliminar'])){
        $id = $_POST['idUsuario'] ?? 0;
        if($id) EliminarU($conexion, $id);
    }

    $historial = [];
    if(isset($_POST['buscar'])){
        $id = $_POST['idBuscar'] ?? 0;
        if($id){
            $historial = HistorialA($conexion, $id);
        }
    }

    $usuarios = ListarU($conexion);

    return ['usuarios'=>$usuarios, 'historial'=>$historial];
}
?>
