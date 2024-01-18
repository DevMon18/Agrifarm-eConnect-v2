<?php 
session_start();

if(!isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Please Login!";
    header("Location: user_login.php");
    exit(0);
}
?>