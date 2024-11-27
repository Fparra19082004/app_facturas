-- Active: 1720526660621@@127.0.0.1@3306@muelle_pesquero
-- Insert test clients
INSERT INTO clientes (nombre, ruc, limite_credito, credito_usado) VALUES
('Pescador S.A.', '20123456789', 25000.00, 15000.00),
('MarFood Inc.', '20987654321', 35000.00, 32000.00);

-- Insert test invoices
INSERT INTO facturas (numero, cliente_id, monto_total, fecha_emision, fecha_vencimiento) VALUES
('F001-128', 1, 2500.00, 11/25/2024, 11/27/2024),
('F001-127', 2, 3800.00, 11/25/2024, 11/27/2024);

-- Insert test credits
INSERT INTO creditos (cliente_id, limite, plazo_dias, fecha_revision) VALUES
(1, 25000.00, 30, CURRENT_DATE),
(2, 35000.00, 30, CURRENT_DATE);
