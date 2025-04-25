-- Active: 1741591537387@@127.0.0.1@3306@sarinih
CREATE DATABASE sarinih;

use sarinih;

ALTER TABLE `order` RENAME TO `orders`;

ALTER TABLE `orders`
MODIFY `id_order` INT(11) NOT NULL AUTO_INCREMENT,
MODIFY `tanggal` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
MODIFY `total` INT(11) DEFAULT NULL,
MODIFY `id_user` INT(11) NOT NULL;

ALTER TABLE `orders`
ADD `status` ENUM('pending', 'diproses', 'selesai', 'dibatalkan') NOT NULL DEFAULT 'pending';

CREATE TABLE order_detail (
  id_detail INT AUTO_INCREMENT PRIMARY KEY,
  id_order INT NOT NULL,
  id_menu INT NOT NULL,
  jumlah INT NOT NULL,
  FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE,
  FOREIGN KEY (id_menu) REFERENCES menu(id_menu) ON DELETE CASCADE
);


-- Buat tabel user_register terlebih dahulu
CREATE TABLE `user` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `fulname` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `create_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_username_unique` (`email`, `username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE user ADD role ENUM('admin', 'user') NOT NULL DEFAULT 'user';

ALTER TABLE orders ADD COLUMN id_user INT NOT NULL;

ALTER TABLE orders
ADD CONSTRAINT fk_orders_user
FOREIGN KEY (id_user) REFERENCES user(id_user)
ON DELETE CASCADE;


SHOW ENGINE INNODB STATUS;
ALTER TABLE `user_register` ENGINE = InnoDB;
ALTER TABLE `contact` ENGINE = InnoDB;
ALTER TABLE `reservasi` ENGINE = InnoDB;


SELECT * from user_register;
SELECT * from reservasi;

SHOW GRANTS FOR CURRENT_USER;
SELECT 
    CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'nama_database' AND REFERENCED_TABLE_NAME IS NOT NULL;

SHOW TABLES;

DESC user_register;
DESC reservasi;

ALTER TABLE reservasi DROP FOREIGN KEY fk_user_email_username;



SHOW VARIABLES LIKE 'max_connections';
SHOW VARIABLES LIKE 'wait_timeout';
SHOW VARIABLES LIKE 'interactive_timeout';

SHOW PROCESSLIST;
SHOW VARIABLES LIKE 'max_connections';

SET GLOBAL max_connections = 500;  -- Setel nilai max_connections menjadi 500

SHOW VARIABLES LIKE 'max_connections';

SHOW VARIABLES LIKE 'wait_timeout';
SHOW VARIABLES LIKE 'interactive_timeout'; 
SHOW VARIABLES LIKE 'wait_timeout';
SHOW VARIABLES LIKE 'interactive_timeout';

SET GLOBAL wait_timeout = 28800;
SET GLOBAL interactive_timeout = 28800;

CREATE TABLE menu (
    id_menu INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    gambar VARCHAR(255) -- Simpan nama file gambar, misalnya 'nasi-goreng.jpg'
);
CREATE TABLE orders (
    id_order INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total INT
);
CREATE TABLE order_items (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_order INT,
    id_menu INT,
    qty INT,
    subtotal INT,
    FOREIGN KEY (id_order) REFERENCES orders(id_order),
    FOREIGN KEY (id_menu) REFERENCES menu(id_menu)
);
