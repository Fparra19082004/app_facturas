-- Create database
CREATE DATABASE muelle_pesquero;

-- Clientes table
CREATE TABLE clientes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ruc VARCHAR(20),
    limite_credito DECIMAL(10,2),
    credito_usado DECIMAL(10,2),
    estado_cliente VARCHAR(20),
    fecha_registro DATE
);

-- Facturas table
CREATE TABLE facturas (
    id INT(20) UNIQUE AUTO_INCREMENT,
    cliente_id VARCHAR(30),
    monto_total FLOAT(20),
    fecha_emision DATE,
    fecha_vencimiento DATE,
    estado_factura VARCHAR(20)
);

-- Cobros table
CREATE TABLE cobros (
    id SERIAL PRIMARY KEY,
    factura_id INTEGER REFERENCES facturas(id),
    monto DECIMAL(10,2),
    metodo_pago VARCHAR(20),
    fecha_pago DATE,
    comentarios TEXT,
    estado_cobro VARCHAR(20),
    fecha_registro DATE
);

-- Creditos table
CREATE TABLE creditos (
    id SERIAL PRIMARY KEY,
    cliente_id INTEGER REFERENCES clientes(id),
    limite DECIMAL(10,2),
    plazo_dias INTEGER(15),
    fecha_revision DATE,
    observaciones TEXT,
    estado_credito VARCHAR(20)
);

-- Create indexes
CREATE INDEX idx_facturas_cliente ON facturas(cliente_id);
CREATE INDEX idx_cobros_factura ON cobros(factura_id);
CREATE INDEX idx_creditos_cliente ON creditos(cliente_id);
