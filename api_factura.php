<?php
// api_cobros.php
require_once 'db_config.php';
require_once 'funciones.php';

$cliente_id = $_POST['cliente'];
$monto = $_POST['granTotal'];
$fecha_emision = $_POST['fecha'];
$fecha_vencimiento = $_POST['fecha'];
// api_cobros.php
if (procesarFactura($cliente_id, $monto, $fecha_emision, $fecha_vencimiento)) {
    $html = '<div>Factura creada exitosamente</div>';
} else {
    $html = '<div>Error al crear la factura</div>';
}
echo $html;
?>
