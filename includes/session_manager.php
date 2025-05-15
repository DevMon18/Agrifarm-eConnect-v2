<?php
if (session_status() === PHP_SESSION_NONE) {
    ob_start();
    session_start();
}

function check_admin_login() {
    if (!isset($_SESSION['admin_id'])) {
        if (ob_get_length()) ob_end_clean();
        header('location: admin_login.php');
        exit();
    }
    return $_SESSION['admin_id'];
}

function ensure_session_started() {
    if (session_status() === PHP_SESSION_NONE) {
        ob_start();
        session_start();
    }
}
?> 