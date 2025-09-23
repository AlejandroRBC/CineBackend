<?php
include_once __DIR__ . "/../../Capa_Datos/conexionBD/conexion.php";

if(isset($_POST['finalizar']) && isset($_POST['items'])){
    $items = $_POST['items'];
    $idUsuario = 1; 
    $total = 0;

    foreach($items as $it){
        $total += $it['precio'] * $it['cantidad'];
    }

    
    $stmt = $conexion->prepare(
        "INSERT INTO VENTA (idUsuario, total, tipo_pago, fecha) VALUES (?, ?, ?, NOW())");
    $tipo_pago = "Efectivo";
    $stmt->bind_param("ids", $idUsuario, $total, $tipo_pago);
    $stmt->execute();
    $idVenta = $stmt->insert_id;

    
    foreach($items as $it){
        if($it['tipo'] === "pelicula"){
            $stmt = $conexion->prepare("INSERT INTO Detalle_venta (idVenta, idPelicula, idButaca, nro_Sala, subtotal) VALUES (?, ?, ?, ?, ?)");
            $idButaca = null; 
            $nro_Sala = 1;    
            $subtotal = $it['precio'] * $it['cantidad'];
            $stmt->bind_param("iiisd", $idVenta, $it['id'], $idButaca, $nro_Sala, $subtotal);
            $stmt->execute();
        } else {
            $stmt = $conexion->prepare("INSERT INTO Detalle_prods (idVenta, idProducto, cantidad, subtotal) VALUES (?, ?, ?, ?)");
            $subtotal = $it['precio'] * $it['cantidad'];
            $stmt->bind_param("iiid", $idVenta, $it['id'], $it['cantidad'], $subtotal);
            $stmt->execute();
        }
    }

    echo "Compra registrada con éxito. ID venta: " . $idVenta;

}
?>
