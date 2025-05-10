CREATE DATABASE ats_scanner;
USE ats_scanner;

CREATE TABLE resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    score FLOAT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
