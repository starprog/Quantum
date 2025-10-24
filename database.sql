-- World Recipes Database Setup
-- Create database and table structure

CREATE DATABASE IF NOT EXISTS world_recipes;
USE world_recipes;

-- Create recipes table
CREATE TABLE IF NOT EXISTS recipes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    country VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    ingredients TEXT NOT NULL,
    steps TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    source_link VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add index for country lookups
CREATE INDEX idx_country ON recipes(country);