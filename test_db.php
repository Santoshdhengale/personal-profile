<?php
// Test database connection
echo "Testing database connection...\n";

try {
    $conn = new mysqli('localhost', 'root', '', '');
    
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error . "\n";
    } else {
        echo "✅ MySQL connection successful!\n";
        
        // Test if contact_db exists
        $result = $conn->query("SHOW DATABASES LIKE 'contact_db'");
        if ($result->num_rows > 0) {
            echo "✅ Database 'contact_db' exists!\n";
            
            // Connect to contact_db and check table
            $conn->select_db('contact_db');
            $result = $conn->query("SHOW TABLES LIKE 'contacts'");
            if ($result->num_rows > 0) {
                echo "✅ Table 'contacts' exists!\n";
                
                // Count records
                $result = $conn->query("SELECT COUNT(*) as count FROM contacts");
                $row = $result->fetch_assoc();
                echo "📊 Records in contacts table: " . $row['count'] . "\n";
            } else {
                echo "❌ Table 'contacts' does not exist!\n";
            }
        } else {
            echo "❌ Database 'contact_db' does not exist!\n";
        }
    }
    $conn->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\nTesting connection.php file...\n";
require_once 'connection.php';

try {
    $conn = getConnection();
    echo "✅ connection.php works correctly!\n";
    
    // Test a simple query
    $result = $conn->query("SELECT COUNT(*) as count FROM contacts");
    $row = $result->fetch_assoc();
    echo "📊 Total contacts: " . $row['count'] . "\n";
    
    $conn->close();
} catch (Exception $e) {
    echo "❌ connection.php error: " . $e->getMessage() . "\n";
}
?>