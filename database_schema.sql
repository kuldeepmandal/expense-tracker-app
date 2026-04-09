-- Spendly Database Schema

CREATE DATABASE IF NOT EXISTS spendly_db;
USE spendly_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    currency_preference VARCHAR(10) DEFAULT 'Rs.',
    base_budget DECIMAL(12,2) DEFAULT 0.00,
    total_savings DECIMAL(12,2) DEFAULT 0.00,
    is_verified TINYINT(1) DEFAULT 0,
    otp_code VARCHAR(6),
    otp_expires_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('expense', 'income') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    payment_method VARCHAR(50),
    description VARCHAR(255),
    notes TEXT,
    transaction_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS budgets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    limit_amount DECIMAL(12,2) NOT NULL,
    month VARCHAR(20) NOT NULL, -- Format: YYYY-MM
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
