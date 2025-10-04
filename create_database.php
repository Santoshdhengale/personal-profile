<?php
// Create database and table for contact form
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_db";

try {
    // Create connection (without specifying database first)
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    echo "✅ Connected to MySQL successfully<br>";

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "✅ Database '$dbname' created successfully<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Select the database
    if (!$conn->select_db($dbname)) {
        throw new Exception("Error selecting database: " . $conn->error);
    }

    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        number VARCHAR(20) NOT NULL,
        address TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Table 'contacts' created successfully<br>";
        echo "<h2>🎉 Database setup complete!</h2>";
        echo "<p><strong>Your contact form is ready to use!</strong></p>";
        echo "<p><a href='index.html' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Contact Form</a></p>";
    } else {
        throw new Exception("Error creating table: " . $conn->error);
    }

    $conn->close();
    
} catch (Exception $e) {
    echo "<h2>❌ Error occurred:</h2>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    echo "<h3>🔧 Troubleshooting:</h3>";
    echo "<ul>";
    echo "<li>Make sure XAMPP is running</li>";
    echo "<li>Check that MySQL service is started</li>";
    echo "<li>Verify database credentials are correct</li>";
    echo "</ul>";
}
?>