<?php
require_once 'includes/init.php';
$admin_id = check_admin_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- ... rest of your head content ... -->
</head>
<body>
    <?php include 'components/admin_sidebar.php'; ?>
    <?php include 'components/admin_cards.php'; ?>
    <!-- ... rest of your content ... -->
</body>
</html> 