<?php
// api_cobros.php
header('Content-Type: application/json');
require_once 'db_config.php';

function getPendingInvoices() {
    global $conn;
    try {
        $stmt = $conn->prepare("
            SELECT f.id, f.numero, c.nombre as cliente, f.monto_total,
                   f.fecha_emision, f.fecha_vencimiento, f.estado::text,
                   COALESCE((SELECT SUM(monto) FROM cobros WHERE factura_id = f.id), 0) as monto_pagado
            FROM facturas f
            JOIN clientes c ON f.cliente_id = c.id
            WHERE f.estado = 'Pendiente'
            ORDER BY f.fecha_vencimiento ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return ["error" => $e->getMessage()];
    }
}

function procesarCobro($data) {
    global $conn;
    try {
        $conn->beginTransaction();

        // Validate payment amount
        $stmt = $conn->prepare("
            SELECT monto_total,
                   COALESCE((SELECT SUM(monto) FROM cobros WHERE factura_id = ?), 0) as monto_pagado
            FROM facturas WHERE id = ?
        ");
        $stmt->execute([$data['factura_id'], $data['factura_id']]);
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($factura['monto_pagado'] + $data['monto'] > $factura['monto_total']) {
            throw new Exception("El monto del pago excede el saldo pendiente");
        }

        // Insert cobro
        $stmt = $conn->prepare("
            INSERT INTO cobros (factura_id, monto, metodo_pago, fecha_pago, comentarios)
            VALUES (:factura_id, :monto, :metodo_pago::metodo_pago, :fecha_pago, :comentarios)
            RETURNING id
        ");
        $stmt->execute([
            'factura_id' => $data['factura_id'],
            'monto' => $data['monto'],
            'metodo_pago' => $data['metodo_pago'],
            'fecha_pago' => $data['fecha_pago'],
            'comentarios' => $data['comentarios']
        ]);

        // Update factura status
        $stmt = $conn->prepare("
            UPDATE facturas
            SET estado = CASE
                WHEN (SELECT SUM(monto) FROM cobros WHERE factura_id = :factura_id) >= monto_total
                THEN 'Pagada'::estado_factura
                ELSE 'Pendiente'::estado_factura
            END
            WHERE id = :factura_id
        ");
        $stmt->execute(['factura_id' => $data['factura_id']]);

        $conn->commit();
        return ["success" => true, "message" => "Cobro procesado exitosamente"];
    } catch(Exception $e) {
        $conn->rollBack();
        return ["error" => $e->getMessage()];
    }
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(getPendingInvoices());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode(procesarCobro($data));
}
?>
