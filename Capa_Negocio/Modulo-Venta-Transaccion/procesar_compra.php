<?php
include_once __DIR__ . "/../../Capa_Datos/conexionBD/conexion.php";

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

function generarFacturaHTML($idVenta, $items, $total, $metodoPago, $conexion) {
    // Obtener información del usuario
    $idUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 123;
    $infoUsuario = [];
    
    if ($idUsuario) {
        $stmt = $conexion->prepare("SELECT nombre, nom_usu, telefono, ci_nit FROM USUARIO WHERE idUsuario = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $infoUsuario = $stmt->get_result()->fetch_assoc();
    }
    
    // Fecha y hora actual
    $fecha = date('d/m/Y');
    $hora = date('H:i:s');
    
    $html = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Factura CineMax</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
            .factura-container { max-width: 800px; margin: 0 auto; border: 2px solid #1a365d; padding: 20px; }
            .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1a365d; padding-bottom: 20px; }
            .header h1 { color: #1a365d; margin: 0; }
            .info-section { display: flex; justify-content: space-between; margin-bottom: 20px; }
            .info-box { flex: 1; padding: 10px; }
            .info-box h3 { color: #1a365d; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
            .tabla-items { width: 100%; border-collapse: collapse; margin: 20px 0; }
            .tabla-items th, .tabla-items td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            .tabla-items th { background-color: #f5f5f5; }
            .total-section { text-align: right; margin-top: 20px; font-size: 1.2em; font-weight: bold; }
            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 0.9em; }
            .logo { font-size: 24px; font-weight: bold; color: #1a365d; }
            .detalle-item { background-color: #f9f9f9; }
        </style>
    </head>
    <body>
        <div class="factura-container">
            <div class="header">
                <div class="logo">CINEMAX</div>
                <h1>FACTURA #' . $idVenta . '</h1>
                <p>Sistema de Cine - Factura de Venta</p>
            </div>
            
            <div class="info-section">
                <div class="info-box">
                    <h3>Información del Cliente</h3>
                    <p><strong>Nombre:</strong> ' . ($infoUsuario ? htmlspecialchars($infoUsuario['nombre']) : 'Cliente Ocasional') . '</p>
                    <p><strong>Usuario:</strong> ' . ($infoUsuario ? htmlspecialchars($infoUsuario['nom_usu']) : 'N/A') . '</p>
                    <p><strong>Teléfono:</strong> ' . ($infoUsuario ? htmlspecialchars($infoUsuario['telefono']) : 'N/A') . '</p>
                    <p><strong>CI/NIT:</strong> ' . ($infoUsuario ? htmlspecialchars($infoUsuario['ci_nit']) : 'N/A') . '</p>
                </div>
                
                <div class="info-box">
                    <h3>Información de la Factura</h3>
                    <p><strong>N° Factura:</strong> ' . $idVenta . '</p>
                    <p><strong>Fecha:</strong> ' . $fecha . '</p>
                    <p><strong>Hora:</strong> ' . $hora . '</p>
                    <p><strong>Método de Pago:</strong> ' . htmlspecialchars($metodoPago) . '</p>
                </div>
            </div>
            
            <h3>Detalle de la Compra</h3>
            <table class="tabla-items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>';
    
    $contador = 1;
    foreach($items as $it) {
        $subtotal = $it['precio'] * $it['cantidad'];
        $html .= '
                    <tr class="detalle-item">
                        <td>' . $contador . '</td>
                        <td>' . htmlspecialchars($it['nombre']) . ' (' . ucfirst($it['tipo']) . ')</td>
                        <td>' . $it['cantidad'] . '</td>
                        <td>Bs. ' . number_format($it['precio'], 2) . '</td>
                        <td>Bs. ' . number_format($subtotal, 2) . '</td>
                    </tr>';
        $contador++;
    }
    
    $html .= '
                </tbody>
            </table>
            
            <div class="total-section">
                <p><strong>TOTAL: Bs. ' . number_format($total, 2) . '</strong></p>
            </div>
            
            <div class="footer">
                <p><strong>¡Gracias por su compra!</strong></p>
                <p>CineMax - Su cine de confianza</p>
                <p>Teléfono: +591 720-429-23 | Email: soporte@cinemax.com</p>
                <p>Esta factura es un comprobante de venta generado electrónicamente</p>
            </div>
        </div>
    </body>
    </html>';
    
    return $html;
}

if(isset($_POST['finalizar']) && isset($_POST['items'])){
    $items = $_POST['items'];
    if (empty($items)) {
        die("Error: No hay items en el carrito");
    }
    if(isset($_SESSION['usuario'])){
        $idUsuario = $_SESSION['usuario']['id']; 
    } else {
        $idUsuario = 123; 
    }
    
    $total = 0;
    foreach($items as $it){
        $total += $it['precio'] * $it['cantidad'];
    }

    // Insertar venta
    $stmt = $conexion->prepare(
        "INSERT INTO VENTA (idUsuario, total, tipo_pago, fecha) VALUES (?, ?, ?, NOW())");
    $tipo_pago = $_POST['metodoPago'];
    
    $stmt->bind_param("ids", $idUsuario, $total, $tipo_pago);
    
    if($stmt->execute()){
        $idVenta = $stmt->insert_id;
        
        // Insertar detalles de la venta
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
        
        // Generar y mostrar factura
        $facturaHTML = generarFacturaHTML($idVenta, $items, $total, $tipo_pago, $conexion);
        
        // Mostrar factura en el navegador
        echo $facturaHTML;
        
    } else {
        echo "Error al procesar la compra: " . $conexion->error;
    }
} else {
    echo "Datos de compra incompletos";
}
?>