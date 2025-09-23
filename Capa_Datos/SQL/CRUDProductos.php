<?php
include __DIR__ . "/../conexionBD/conexion.php";

function ListarProductosDisponibles($conexion){
    $sql = "SELECT * FROM productos WHERE stock>0 AND activo like 'Activo'";
    return $conexion->query($sql);
}

function ObtenerProducto($conexion, $idProducto){
    $sql = "SELECT * FROM productos WHERE idProducto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function ActualizarStock($conexion, $idProducto, $cantidad){
    $sql = "UPDATE PRODUCTOS SET stock = stock - ? WHERE idProducto = ? AND stock >= ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iii", $cantidad, $idProducto, $cantidad);
    return $stmt->execute();
}

function VerificarStock($conexion, $idProducto, $cantidad){
    $sql = "SELECT stock FROM PRODUCTOS WHERE idProducto = ? AND stock >= ? AND activo = 'Activo'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $idProducto, $cantidad);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->num_rows > 0;
}
?>