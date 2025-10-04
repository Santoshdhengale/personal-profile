<?php
// Include the database connection file
require_once 'connection.php';

// Check if this is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    try {
        // Get database connection
        $conn = getConnection();
        
        // Get and sanitize form data
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $number = mysqli_real_escape_string($conn, trim($_POST['number']));
        $address = mysqli_real_escape_string($conn, trim($_POST['address']));
        
        // Basic validation
        if (empty($name) || empty($email) || empty($number) || empty($address)) {
            if ($isAjax) {
                echo "❌ All fields are required!";
            } else {
                showErrorPage("All fields are required!");
            }
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($isAjax) {
                echo "❌ Please enter a valid email address!";
            } else {
                showErrorPage("Please enter a valid email address!");
            }
            exit;
        }
        
        // Use prepared statement for better security
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, number, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $number, $address);
        
        if ($stmt->execute()) {
            if ($isAjax) {
                echo "✔️ Contact saved successfully! Thank you, $name! Your message has been received.";
            } else {
                showSuccessPage($name);
            }
        } else {
            if ($isAjax) {
                echo "❌ Error: " . $stmt->error;
            } else {
                showErrorPage("Database error occurred. Please try again.");
            }
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        if ($isAjax) {
            echo "❌ Database Error: " . $e->getMessage();
        } else {
            showErrorPage("Database connection error. Please try again later.");
        }
    }
    
} else {
    // If not POST request, redirect to home page
    header("Location: index.html");
    exit();
}

// Function to show success page
function showSuccessPage($name) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message Sent Successfully</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .success-container {
                min-height: 100vh;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .success-card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            .success-icon {
                font-size: 4rem;
                color: #28a745;
                animation: bounceIn 1s ease-out;
            }
            @keyframes bounceIn {
                0% { transform: scale(0); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
            .btn-back {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                padding: 12px 30px;
                border-radius: 50px;
                transition: all 0.3s ease;
            }
            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            }
        </style>
    </head>
    <body>
        <div class="success-container d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="success-card p-5 text-center">
                            <div class="success-icon mb-4">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h2 class="text-success mb-3">Message Sent Successfully!</h2>
                            <h4 class="mb-4">Thank you, <?php echo htmlspecialchars($name); ?>!</h4>
                            <p class="text-muted mb-4">
                                Your message has been received successfully. I'll get back to you as soon as possible.
                            </p>
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="index.html" class="btn btn-back text-white">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Portfolio
                                </a>
                                <a href="index.html#contact" class="btn btn-outline-secondary">
                                    <i class="fas fa-envelope me-2"></i>
                                    Send Another Message
                                </a>
                            </div>
                            
                            <div class="mt-5 pt-4 border-top">
                                <p class="small text-muted mb-0">
                                    <i class="fas fa-clock me-1"></i>
                                    Message sent on <?php echo date('F j, Y \a\t g:i A'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Auto redirect after 10 seconds
            setTimeout(function() {
                window.location.href = 'index.html';
            }, 10000);
            
            // Add some confetti effect
            document.addEventListener('DOMContentLoaded', function() {
                // Simple celebration animation
                const icon = document.querySelector('.success-icon');
                icon.addEventListener('animationend', function() {
                    icon.style.animation = 'pulse 2s infinite';
                });
            });
        </script>
    </body>
    </html>
    <?php
}

// Function to show error page
function showErrorPage($errorMessage) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error - Message Not Sent</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .error-container {
                min-height: 100vh;
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            }
            .error-card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            .error-icon {
                font-size: 4rem;
                color: #dc3545;
                animation: shake 0.5s ease-in-out;
            }
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            .btn-back {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                padding: 12px 30px;
                border-radius: 50px;
                transition: all 0.3s ease;
            }
            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            }
        </style>
    </head>
    <body>
        <div class="error-container d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="error-card p-5 text-center">
                            <div class="error-icon mb-4">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h2 class="text-danger mb-3">Oops! Something went wrong</h2>
                            <p class="text-muted mb-4">
                                <?php echo htmlspecialchars($errorMessage); ?>
                            </p>
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="index.html#contact" class="btn btn-back text-white">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Try Again
                                </a>
                                <a href="index.html" class="btn btn-outline-secondary">
                                    <i class="fas fa-home me-2"></i>
                                    Back to Portfolio
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
?>
