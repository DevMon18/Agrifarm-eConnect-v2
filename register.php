<?php
session_start();
require_once 'conn.php';
require_once 'mail.php';

if (isset($_POST['register_btn'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $number = $_POST['number'];
    $password = sha1($_POST['password']);
    $verify_token = md5(rand());

    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0)
    {
        $_SESSION['status'] = "Email Already Exists";
        header("Location: user_register.php");
    }
    else
    {
        $query = "INSERT INTO users (name, email, address, number, password, verify_token) VALUES ('$name', '$email', '$address', '$number', '$password', '$verify_token')";
        $query_run = mysqli_query($con,  $query);
        
        if($query_run)
        {
            sendemail_verify("$name", "$email", "$verify_token");
            $_SESSION['status'] = "Registration Successful! Please Verify Your Email Address";
            header("Location: user_register.php");
        } else {
            $_SESSION['status'] = "Registration Failed";
            header("Location: user_register.php");
        }
    }
}
?>