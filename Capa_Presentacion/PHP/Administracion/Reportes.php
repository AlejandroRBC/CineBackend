<?php
include "../../../Capa_Negocio/Modulo-Administracion/Gestion_ComercialN.php";
session_start();
$resultado = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $resultado = LogicaR($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes</title>
<link rel="stylesheet" href="../../CSS/Administracion/Gestion_ComercialC.css">
</head>
<body>
<?php include "../../HTML/Administracion/Navbar.html"; ?>

<h2>Reportes</h2>

<form method="POST">
    <label>Tipo de reporte:</label>
    <select name="tipoReporte" required>
        <option value="ventas">Ventas realizadas</option>
        <option value="horarios">Horarios mas llenos</option>
        <option value="peliculas">Películas mas vendidas</option>
    </select>

    <label>Intervalo:</label>
    <select name="intervalo" required>
        <option value="semana">Semana</option>
        <option value="mes">Mes</option>
        <option value="anio">Año</option>
    </select>

    <label>Fecha de referencia:</label>
    <input type="date" name="fechaRef" value="<?= date('Y-m-d') ?>" required>

    <button type="submit">Generar reporte</button>
</form>

<?php if(isset($resultado['tabla'])): ?>
    <h3>Resultados</h3>
    <table>
        <tr>
        <?php
        $fila = $resultado['tabla']->fetch_assoc();
        if($fila){
            foreach($fila as $col => $val){
                echo "<th>$col</th>";
            }
            echo "</tr><tr>";
            foreach($fila as $col => $val){
                echo "<td>$val</td>";
            }
            echo "</tr>";
            while($fila = $resultado['tabla']->fetch_assoc()){
                echo "<tr>";
                foreach($fila as $col => $val){
                    echo "<td>$val</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<th>Sin datos para estas fechas</th></tr>";
        }
        ?>
    </table>
<?php endif; ?>

</body>
</html>
