<?php
include "../../../Capa_Datos/conexionBd/conexion.php";

function AgregarP($conexion, $nom_pel, $lenguaje, $formato, $categoria, $fecha_lanzamiento, $clasificacion, $sonido){
    $stmt = $conexion->prepare("INSERT INTO PELICULA (nom_pel, lenguaje, formato, categoria, fecha_lanzamiento, clasificacion, sonido) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nom_pel, $lenguaje, $formato, $categoria, $fecha_lanzamiento, $clasificacion, $sonido);
    $stmt->execute();
    $stmt->close();
}

function ModificarP($conexion, $id, $nom_pel, $lenguaje, $formato, $categoria, $fecha_lanzamiento, $clasificacion, $sonido, $estado){
    $stmt = $conexion->prepare("UPDATE PELICULA SET nom_pel=?, lenguaje=?, formato=?, categoria=?, fecha_lanzamiento=?, clasificacion=?, sonido=?, estado=? WHERE idPelicula=?");
    $stmt->bind_param("ssssssssi", $nom_pel, $lenguaje, $formato, $categoria, $fecha_lanzamiento, $clasificacion, $sonido, $estado, $id);
    $stmt->execute();
    $stmt->close();
}

function ListarP($conexion){
    return $conexion->query("SELECT * FROM PELICULA");
}

function AgregarPr($conexion, $idPelicula, $nro_Sala, $fecha, $hora){
    $stmt = $conexion->prepare("INSERT INTO Se_proyecta (idPelicula, nro_Sala, fecha, hora) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $idPelicula, $nro_Sala, $fecha, $hora);
    $stmt->execute();
    $stmt->close();
}

function ModificarPr($conexion, $id, $idPelicula, $nro_Sala, $fecha, $hora){
    $stmt = $conexion->prepare("UPDATE Se_proyecta SET idPelicula=?, nro_Sala=?, fecha=?, hora=? WHERE idProyeccion=?");
    $stmt->bind_param("iissi", $idPelicula, $nro_Sala, $fecha, $hora, $id);
    $stmt->execute();
    $stmt->close();
}

function EliminarPr($conexion, $id){
    $stmt = $conexion->prepare("UPDATE Se_proyecta SET fecha='0000-00-00' WHERE idProyeccion=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function ListarPr($conexion){
    return $conexion->query("SELECT * FROM Se_proyecta");
}

function LogicaGC($conexion){
    session_start();

    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();
        header("Location: Sesion.php");
        exit();
    }

    if(isset($_POST['agregarPelicula'])){
        $nom_pel = $_POST['nom_pel'] ?? '';
        $lenguaje = $_POST['lenguaje'] ?? '';
        $formato = $_POST['formato'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $fecha_lanzamiento = $_POST['fecha_lanzamiento'] ?? '';
        $clasificacion = $_POST['clasificacion'] ?? '';
        $sonido = $_POST['sonido'] ?? '';

        if($nom_pel && $formato){
            AgregarP($conexion, $nom_pel, $lenguaje, $formato, $categoria, $fecha_lanzamiento, $clasificacion, $sonido);
        }
    }

    if(isset($_POST['modificarPelicula'])){
    $id = $_POST['idPelicula'] ?? 0;
    $nom_pel = $_POST['nom_pel'] ?? '';
    $lenguaje = $_POST['lenguaje'] ?? '';
    $formato = $_POST['formato'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $fecha_lanzamiento = $_POST['fecha_lanzamiento'] ?? '';
    $clasificacion = $_POST['clasificacion'] ?? '';
    $sonido = $_POST['sonido'] ?? '';
    $estado = $_POST['estado'] ?? 'En proyección';

    if($id && $nom_pel && $formato){
        ModificarP($conexion, $id, $nom_pel, $lenguaje, $formato, $categoria, $fecha_lanzamiento, $clasificacion, $sonido, $estado);
    }
}


    if(isset($_POST['agregarProyeccion'])){
        $idPelicula = $_POST['idPelicula'] ?? 0;
        $nro_Sala = $_POST['nro_Sala'] ?? 0;
        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';

        if($idPelicula && $nro_Sala && $fecha && $hora){
            AgregarPr($conexion, $idPelicula, $nro_Sala, $fecha, $hora);
        }
    }

    if(isset($_POST['modificarProyeccion'])){
    $id = $_POST['idProyeccion'] ?? 0;
    $idPelicula = $_POST['idPelicula'] ?? 0;
    $nro_Sala = $_POST['nro_Sala'] ?? 0;
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';

    if($id && $idPelicula && $nro_Sala && $fecha && $hora){
        ModificarPr($conexion, $id, $idPelicula, $nro_Sala, $fecha, $hora);
    }
}


    if(isset($_POST['eliminarProyeccion'])){
        $id = $_POST['idProyeccion'] ?? 0;
        if($id){
            EliminarPr($conexion, $id);
        }
    }

    $peliculas = ListarP($conexion);
    $proyecciones = ListarPr($conexion);

    return ['peliculas' => $peliculas, 'proyecciones' => $proyecciones];
}





function AgregarPro($conexion, $nombre, $precio, $descripcion, $stock, $es_combo){
    $stmt = $conexion->prepare("INSERT INTO PRODUCTOS (nombre, precio, descripcion, stock, es_combo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsis", $nombre, $precio, $descripcion, $stock, $es_combo);
    $stmt->execute();
    $stmt->close();
}

function ModificarPro($conexion, $id, $nombre, $precio, $descripcion, $stock, $es_combo, $activo){
    $stmt = $conexion->prepare("UPDATE PRODUCTOS SET nombre=?, precio=?, descripcion=?, stock=?, es_combo=?, activo=? WHERE idProducto=?");
    $stmt->bind_param("sdsissi", $nombre, $precio, $descripcion, $stock, $es_combo, $activo, $id);
    $stmt->execute();
    $stmt->close();
}

function EliminarPro($conexion, $id){
    $stmt = $conexion->prepare("UPDATE PRODUCTOS SET nombre='0' WHERE idProducto=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function ListarPro($conexion){
    return $conexion->query("SELECT * FROM PRODUCTOS WHERE nombre!='0'");
}

function LogicaPC($conexion){
    session_start();

    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();
        header("Location: Sesion.php");
        exit();
    }

    if(isset($_POST['agregarProducto'])){
        $nombre = $_POST['nombre'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $descripcion = $_POST['descripcion'] ?? '';
        $stock = $_POST['stock'] ?? 0;
        $es_combo = $_POST['es_combo'] ?? 'False';

        if($nombre && $precio > 0 && $stock >= 0){
            AgregarPro($conexion, $nombre, $precio, $descripcion, $stock, $es_combo);
        }
    }

    if(isset($_POST['modificarProducto'])){
        $id = $_POST['idProducto'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $descripcion = $_POST['descripcion'] ?? '';
        $stock = $_POST['stock'] ?? 0;
        $es_combo = $_POST['es_combo'] ?? 'False';
        $activo = $_POST['activo'] ?? 'Activo';

        if($id && $nombre && $precio > 0 && $stock >= 0){
            ModificarPro($conexion, $id, $nombre, $precio, $descripcion, $stock, $es_combo, $activo);
        }
    }

    if(isset($_POST['eliminarProducto'])){
        $id = $_POST['idProducto'] ?? 0;
        if($id){
            EliminarPro($conexion, $id);
        }
    }

    $productos = ListarPro($conexion);
    return ['productos' => $productos];
}






function Semana($date) {
    $ts = strtotime($date);
    $start = date('Y-m-d', strtotime('Lunes', $ts));
    $end = date('Y-m-d', strtotime('Domingo', $ts));
    return ['i' => $start, 'f' => $end];
}


function Mes($date) {
    $start = date('Y-m-01', strtotime($date));
    $end = date('Y-m-t', strtotime($date));
    return ['i' => $start, 'f' => $end];
}

function Anio($date) {
    $year = date('Y', strtotime($date));
    $start = "$year-01-01";
    $end = "$year-12-31";
    return ['i' => $start, 'f' => $end];
}


function VentasI($conexion, $inicio, $fin) {
    $sql = "SELECT v.idVenta, v.fecha, v.total, u.nombre AS cliente
            FROM VENTA v
            LEFT JOIN USUARIO u ON u.idUsuario = v.idUsuario
            WHERE v.fecha BETWEEN ? AND ?
            ORDER BY v.fecha";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $inicio, $fin);
    $stmt->execute();
    return $stmt->get_result();
}

function HorarioLL($conexion, $inicio, $fin) {
    $sql = "SELECT sp.hora AS horario,
                   COUNT(DISTINCT v.idUsuario) AS asistentes
            FROM Se_proyecta sp
            LEFT JOIN DETALLE_VENTA dv 
                   ON dv.idPelicula = sp.idPelicula 
                  AND dv.nro_Sala = sp.nro_Sala
            LEFT JOIN VENTA v
                   ON dv.idVenta = v.idVenta
                  AND v.fecha BETWEEN ? AND ?
            GROUP BY sp.hora
            ORDER BY asistentes DESC";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $inicio, $fin);
    $stmt->execute();
    return $stmt->get_result();
}



function PeliculasV($conexion, $inicio, $fin) {
    $sql = "SELECT p.nom_pel, COUNT(dv.idDetalle_venta) AS entradas_vendidas, SUM(dv.subtotal) AS total_recaudado
            FROM DETALLE_VENTA dv
            LEFT JOIN PELICULA p ON p.idPelicula = dv.idPelicula
            LEFT JOIN VENTA v ON v.idVenta = dv.idVenta
            WHERE v.fecha BETWEEN ? AND ?
            GROUP BY p.nom_pel
            ORDER BY entradas_vendidas DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $inicio, $fin);
    $stmt->execute();
    return $stmt->get_result();
}

function LogicaR($conexion) {
    $tipoReporte = $_POST['tipoReporte'] ?? '';
    $intervalo = $_POST['intervalo'] ?? 'semana';
    $fechaRef = $_POST['fechaRef'] ?? date('Y-m-d');

    switch($intervalo) {
        case 'semana':
            $dates = Semana($fechaRef);
            break;
        case 'mes':
            $dates = Mes($fechaRef);
            break;
        case 'anio':
            $dates = Anio($fechaRef);
            break;
        default:
            $dates = ['i'=>$fechaRef, 'f'=>$fechaRef];
    }

    $inicio = $dates['i'];
    $fin = $dates['f'];

    $resultado = [];
    if($tipoReporte == 'ventas') {
        $resultado['tabla'] = VentasI($conexion, $inicio, $fin);
    } elseif($tipoReporte == 'horarios') {
        $resultado['tabla'] = HorarioLL($conexion, $inicio, $fin);
    } elseif($tipoReporte == 'peliculas') {
        $resultado['tabla'] = PeliculasV($conexion, $inicio, $fin);
    }

    return $resultado;
}

?>





