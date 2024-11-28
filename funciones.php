<?php
require_once 'db_config.php';


function procesarFactura($cliente_id, $monto, $fecha_emision, $fecha_vencimiento) {
    $conexion= new ConexionBD("localhost", "muelle_pesquero", "root", "");
    
    try {
        $query= "INSERT INTO facturas (cliente_id, monto_total, fecha_emision, fecha_vencimiento, estado_factura)
        VALUES (:cliente_id, :monto, :fecha_emision, :fecha_vencimiento, 'pendiente')";
        $conexion ->conectar();
        $stmt = $conexion->prepararConsulta($query);
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->bindParam(":monto", $monto);
        $stmt->bindParam(":fecha_emision", $fecha_emision);
        $stmt->bindParam(":fecha_vencimiento", $fecha_vencimiento);
        $stmt->execute();
        $filasAfectadas = $stmt->rowCount();
            if ($filasAfectadas > 0) {
                return true;
            } else {
                return false;
            }
    } catch(Exception $e) { 
        echo "Error al agregar la factura: " . $e->getMessage();
        return false;
    }
}
