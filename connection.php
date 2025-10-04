<?php
// Database connection file
// This file handles all database connections

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_db";

// Function to get database connection with auto-setup
function getConnection() {
    global $servername, $username, $password, $dbname;
    
    try {
        // First connect without database
        $conn = new mysqli($servername, $username, $password);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Create database if it doesn't exist
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if (!$conn->query($sql)) {
            throw new Exception("Error creating database: " . $conn->error);
        }
        
        // Select the database
        if (!$conn->select_db($dbname)) {
            throw new Exception("Error selecting database: " . $conn->error);
        }
        
        // Create table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            number VARCHAR(20) NOT NULL,
            address TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if (!$conn->query($sql)) {
            throw new Exception("Error creating table: " . $conn->error);
        }
        
        // Set charset
        $conn->set_charset("utf8");
        
        return $conn;
        
    } catch (Exception $e) {
        die("Database Error: " . $e->getMessage());
    }
}

// Simple connection (if database already exists)
function simpleConnection() {
    global $servername, $username, $password, $dbname;
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?>