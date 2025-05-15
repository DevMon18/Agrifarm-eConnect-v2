<?php
session_start();
require_once 'conn.php';
require_once 'mail.php';

if (isset($_POST['register_btn'])) {
    // Sanitize inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid email format";
        header("Location: user_register.php");
        exit();
    }

    // Validate password strength
    if (strlen($password) < 8) {
        $_SESSION['status'] = "Password must be at least 8 characters long";
        header("Location: user_register.php");
        exit();
    }

    // Hash password
    $password = sha1($password); // Consider using password_hash() instead
    $verify_token = bin2hex(random_bytes(32)); // More secure token generation

    // Use prepared statements to prevent SQL injection
    $check_email_stmt = $con->prepare("SELECT email FROM users WHERE email = ? LIMIT 1");
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $result = $check_email_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['status'] = "Email Already Exists";
        header("Location: user_register.php");
        exit();
    }

    // Insert new user
    $insert_stmt = $con->prepare("INSERT INTO users (name, email, address, number, password, verify_token) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("ssssss", $name, $email, $address, $number, $password, $verify_token);
    
    if ($insert_stmt->execute()) {
        // Try to send verification email
        if (sendemail_verify($name, $email, $verify_token)) {
            $_SESSION['status'] = "Registration Successful! Please check your email to verify your account.";
        } else {
            // Email failed to send but user was created
            $_SESSION['status'] = "Registration Successful! But there was a problem sending the verification email. Please contact support.";
            error_log("Failed to send verification email to: $email");
        }
    } else {
        $_SESSION['status'] = "Registration Failed: " . $con->error;
        error_log("Registration failed for email $email: " . $con->error);
    }

    header("Location: user_register.php");
    exit();
}
?>