CREATE DATABASE IF NOT EXISTS agua;
USE agua;

-- Tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    rol ENUM('administrador','contadora') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (usuario, contrasena, nombre_completo, rol) 
VALUES ('admin', 'admin123', 'Administrador del Sistema', 'administrador');

-- Tabla clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(13) NOT NULL UNIQUE,
    nombres_completos VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    direccion TEXT NOT NULL,
    correo VARCHAR(100),
    valor_instalacion DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla pagos
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    mes ENUM('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre') NOT NULL,
    anio INT NOT NULL,
    valor_mes DECIMAL(10,2) NOT NULL,
    valor_multa DECIMAL(10,2) DEFAULT 0.00,
    total_pagar DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente','pagado') DEFAULT 'pagado',
    comprobante_pdf VARCHAR(255),
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabla multas
CREATE TABLE multas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    motivo TEXT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha DATE NOT NULL,
    estado ENUM('vigente','pagada') DEFAULT 'vigente',
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabla reuniones_mingas
CREATE TABLE reuniones_mingas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    tipo ENUM('minga','reunion','trabajo_extra') NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla asistencia
CREATE TABLE asistencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reunion_id INT NOT NULL,
    cliente_id INT NOT NULL,
    presente BOOLEAN NOT NULL,
    justificacion TEXT,
    FOREIGN KEY (reunion_id) REFERENCES reuniones_mingas(id) ON DELETE CASCADE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    UNIQUE KEY unico_registro (reunion_id, cliente_id)
);

-- Tabla ingresos
CREATE TABLE ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('instalacion','multa','auspicio') NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla egresos
CREATE TABLE egresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('gasto','insumo_material') NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla sesiones_chat
CREATE TABLE sesiones_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telefono VARCHAR(15) NOT NULL,
    paso INT DEFAULT 1,
    cliente_id INT NULL,
    ultimo_mensaje TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);