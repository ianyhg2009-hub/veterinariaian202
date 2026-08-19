CREATE DATABASE IF NOT EXISTS santuario_mascotas 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE santuario_mascotas;

CREATE TABLE IF NOT EXISTS Mascotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raza VARCHAR(50) NOT NULL,
    edad INT NOT NULL,
    peso_actual DECIMAL(5, 2) NOT NULL,
    color_senas TEXT NOT NULL,
    nombre_responsable VARCHAR(100) NOT NULL,
    telefono_emergencia VARCHAR(20) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);