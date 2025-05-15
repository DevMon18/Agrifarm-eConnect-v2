<?php
// Ensure this is included before ANY output
require_once __DIR__ . '/session_manager.php';
ensure_session_started();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set proper content type and encoding
header('Content-Type: text/html; charset=utf-8');

// Prevent caching for dynamic content
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Time zone setting
date_default_timezone_set('Asia/Manila'); // Adjust for your location

// Database connection
require_once __DIR__ . '/../components/connect.php';
?> 