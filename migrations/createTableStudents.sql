-- Active: 1746528592495@@127.0.0.1@3306@ecommerce1
create DATABASE school;
use school;
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    course VARCHAR(255) NOT NULL
);






