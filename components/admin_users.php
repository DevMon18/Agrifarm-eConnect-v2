<?php

require_once '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:index.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_user->execute([$delete_id]);
    $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
    $delete_orders->execute([$delete_id]);
    $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
    $delete_messages->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:users_accounts1.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users Accounts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/index.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed antialiased">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>User Accounts</h3>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="row ">
        <?php
            $select_accounts = $conn->prepare("SELECT * FROM `users`");
            $select_accounts->execute();
            if ($select_accounts->rowCount() > 0) {
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="col-md-3 d-flex align-items-stretch flex-column">
                <div class="card-body card shadow rounded-lg">
                    <h6 class="mb-3">User ID: <?= $fetch_accounts['id']; ?></h6>
                    <h6 class="text-primary">Name:<span> <?= $fetch_accounts['name']; ?></span></h6>
                    <h6>Email:<span> <?= $fetch_accounts['email']; ?></span></h6>
                    <!-- Update button -->
                    <div class="text-center mt-2 mb-2">
                        <a href="users_accounts1.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="btn btn-block btn-danger">Delete</a>
                    </div>
                </div>
            </div>
                <?php
                    }
                } else {
                echo '<p class="text-center ml-4">No Accounts Available!</p>';
                
                }
                ?>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="../js/admin_script.js"></script>
    <script src="../js/carousel.js"></script>
    <script src="../js/index.js"></script>
    <script src="../js/input.js"></script>
    <script src="../js/image.js"></script>
    <script src="../js/app.min.js"></script>
    <script src="../js/admin_script.js"></script>
</body>
</html>