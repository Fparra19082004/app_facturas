-- Create database
CREATE DATABASE muelle_pesquero;

-- Connect to database
\c muelle_pesquero;

-- Create ENUM types
CREATE TYPE estado_cliente AS ENUM ('Activo', 'Inactivo', 'Suspendido');
CREATE TYPE estado_factura AS ENUM ('Pendiente', 'Pagada', 'Vencida');
CREATE TYPE metodo_pago AS ENUM ('Efectivo', 'Tarjeta', 'Transferencia', 'Cheque');
CREATE TYPE estado_cobro AS ENUM ('Procesado', 'Anulado');
CREATE TYPE estado_credito AS ENUM ('Activo', 'Suspendido', 'Cancelado');

-- Clientes table
CREATE TABLE clientes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ruc VARCHAR(20),
    limite_credito DECIMAL(10,2),
    credito_usado DECIMAL(10,2),
    estado estado_cliente DEFAULT 'Activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Facturas table
CREATE TABLE facturas (
    id SERIAL PRIMARY KEY,
    numero VARCHAR(20) UNIQUE NOT NULL,
    cliente_id INTEGER REFERENCES clientes(id),
    monto_total DECIMAL(10,2),
    fecha_emision DATE,
    fecha_vencimiento DATE,
    estado estado_factura DEFAULT 'Pendiente'
);

-- Cobros table
CREATE TABLE cobros (
    id SERIAL PRIMARY KEY,
    factura_id INTEGER REFERENCES facturas(id),
    monto DECIMAL(10,2),
    metodo_pago metodo_pago,
    fecha_pago DATE,
    comentarios TEXT,
    estado estado_cobro DEFAULT 'Procesado',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creditos table
CREATE TABLE creditos (
    id SERIAL PRIMARY KEY,
    cliente_id INTEGER REFERENCES clientes(id),
    limite DECIMAL(10,2),
    plazo_dias INTEGER,
    fecha_revision DATE,
    observaciones TEXT,
    estado estado_credito DEFAULT 'Activo'
);

-- Create indexes
CREATE INDEX idx_facturas_cliente ON facturas(cliente_id);
CREATE INDEX idx_cobros_factura ON cobros(factura_id);
CREATE INDEX idx_creditos_cliente ON creditos(cliente_id);
