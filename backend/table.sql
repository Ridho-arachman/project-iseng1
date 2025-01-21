CREATE DATABASE IF NOT EXISTS uas_html;

USE uas_html;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', PASSWORD_HASH('password123',
PASSWORD_BCRYPT));