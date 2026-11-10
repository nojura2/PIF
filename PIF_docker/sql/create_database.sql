-- Example script - NOT executed automatically.
-- Run it via phpMyAdmin (Import / SQL tab) or:
--   docker compose exec -T db mysql -uroot -proot < sql/create_database.sql

CREATE DATABASE IF NOT EXISTS pif
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE pif;

CREATE TABLE IF NOT EXISTS example (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO example (name) VALUES ('Hello Docker'), ('LAMP is running');
