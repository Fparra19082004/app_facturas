<?php
// utils.php
function logError($error, $context = []) {
    $logFile = __DIR__ . '/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $errorMessage = "[{$timestamp}] {$error}\n";
    if (!empty($context)) {
        $errorMessage .= "Context: " . json_encode($context) . "\n";
    }
    error_log($errorMessage, 3, $logFile);
}

function validatePaymentData($data) {
    $errors = [];

    if (!isset($data['factura_id']) || !is_numeric($data['factura_id'])) {
        $errors[] = "ID de factura inválido";
    }

    if (!isset($data['monto']) || !is_numeric($data['monto']) || $data['monto'] <= 0) {
        $errors[] = "Monto inválido";
    }

    if (!isset($data['metodo_pago']) || !in_array($data['metodo_pago'],
        ['Efectivo', 'Tarjeta', 'Transferencia', 'Cheque'])) {
        $errors[] = "Método de pago inválido";
    }

    if (!isset($data['fecha_pago']) || !strtotime($data['fecha_pago'])) {
        $errors[] = "Fecha de pago inválida";
    }

    return $errors;
}
?>
