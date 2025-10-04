<?php
// Quick debug script to test form submission
echo "🔍 Form Submission Debug Test\n";
echo "============================\n\n";

// Test 1: Check if we can include the connection file
echo "Test 1: Testing connection.php inclusion...\n";
try {
    require_once 'connection.php';
    echo "✅ connection.php included successfully\n\n";
} catch (Exception $e) {
    echo "❌ Error including connection.php: " . $e->getMessage() . "\n\n";
}

// Test 2: Test database connection
echo "Test 2: Testing database connection...\n";
try {
    $conn = getConnection();
    echo "✅ Database connection successful\n";
    
    // Test table structure
    $result = $conn->query("DESCRIBE contacts");
    echo "✅ Table structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo "   - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    echo "\n";
    
    $conn->close();
} catch (Exception $e) {
    echo "❌ Database connection error: " . $e->getMessage() . "\n\n";
}

// Test 3: Simulate form submission
echo "Test 3: Simulating form submission...\n";
try {
    $_POST['name'] = 'Debug Test User';
    $_POST['email'] = 'debug@test.com';
    $_POST['number'] = '1234567890';
    $_POST['address'] = 'This is a debug test message from the debug script.';
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    $conn = getConnection();
    
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $number = mysqli_real_escape_string($conn, trim($_POST['number']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, number, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $number, $address);
    
    if ($stmt->execute()) {
        echo "✅ Test record inserted successfully!\n";
        echo "   Record ID: " . $conn->insert_id . "\n";
    } else {
        echo "❌ Insert failed: " . $stmt->error . "\n";
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Form simulation error: " . $e->getMessage() . "\n";
}

echo "\n🎯 Recommendation: Use test_form.html to test the AJAX functionality\n";
echo "📂 Visit: http://localhost/contact_form/test_form.html\n";
echo "📄 Main form: http://localhost/contact_form/index.html\n";
?>