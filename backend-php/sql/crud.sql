-- =============================================================================
--  ESQUEMA  ·  CRUD Electrónica (MySQL / MariaDB · InnoDB · utf8mb4)
--  Mantiene el esquema original (crud_angular_mysql · columna createdAt) y
--  añade utf8mb4 para que los acentos y el euskera no se doble-codifiquen.
--  Importar con phpMyAdmin (Importar) o por terminal (MAMP, puerto 8889):
--    /Applications/MAMP/Library/bin/mysql -u root -p -h 127.0.0.1 -P 8889 \
--      < backend-php/sql/crud.sql
-- =============================================================================

-- Fuerza la conexión de importación a utf8mb4. Sin esto, algunos clientes
-- (mysql CLI en latin1) doble-codifican tildes/ñ/euskera. Imprescindible.
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `crud_angular_mysql`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `crud_angular_mysql`;

CREATE TABLE IF NOT EXISTS `productos` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `nombre`      VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `precio`      DECIMAL(10,2) NOT NULL,
  `stock`       INT NOT NULL,
  `createdAt`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --- Datos de ejemplo (opcional) ---------------------------------------------
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`) VALUES
  ('Laptop Dell XPS 13',          'Laptop de alta gama con pantalla 4K',   1299.99, 15),
  ('iPhone 15 Pro',               'Último modelo con cámara avanzada',      999.99, 25),
  ('Monitor LG UltraWide',        'Monitor de 34 pulgadas curvo',           499.99, 10),
  ('Teclado Mecánico Logitech',   'Teclado con switches Cherry MX',         129.99, 30),
  ('Auriculares Sony WH-1000XM5',  'Cancelación de ruido premium',           349.99, 20);
