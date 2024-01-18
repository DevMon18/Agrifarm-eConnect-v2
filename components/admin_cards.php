<?php

require_once '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/index.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
    <body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed antialiased">
<!-- Dashboard cards header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Dashboard</h3>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard cards content -->
<section class="content">
    <div class="container-fluid">
        <!-- Pendings -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $total_pendings = 0;
                        $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_pendings->execute(['pending']);
                        if($select_pendings->rowCount() > 0){
                        while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                            $total_pendings += $fetch_pendings['total_price'];
                        }
                        }
                    ?>
                    <span class="info-box-icon bg-warning elevation-1"><i class="bi bi-hourglass-split"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pendings</span>
                        <span class="info-box-number"><span>₱</span> <?= $total_pendings; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $total_completes = 0;
                        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        if($select_completes->rowCount() > 0){
                        while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                            $total_completes += $fetch_completes['total_price'];
                        }
                        }
                    ?>
                    <span class="info-box-icon bg-success elevation-1"><i class="bi bi-bag-check-fill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Completed Orders</span>
                        <span class="info-box-number"><span>₱</span> <?= $total_completes; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $number_of_orders = $select_orders->rowCount()
                    ?>
                        <span class="info-box-icon bg-warning elevation-1"><i class="bi bi-cart-check-fill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Placed Orders</span>
                        <span class="info-box-number"><?= $number_of_orders; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $number_of_products = $select_products->rowCount()
                    ?>
                    <span class="info-box-icon bg-success elevation-1"><i class="bi bi-check-lg"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Products Added</span>
                        <span class="info-box-number"><?= $number_of_products; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $select_admins = $conn->prepare("SELECT * FROM `admins`");
                        $select_admins->execute();
                        $number_of_admins = $select_admins->rowCount()
                    ?>
                    <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-person-fill-lock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Admin</span>
                        <span class="info-box-number"><?= $number_of_admins; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount()
                    ?>
                    <span class="info-box-icon bg-primary elevation-1"><i class="bi bi-people-fill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Users</span>
                        <span class="info-box-number"><?= $number_of_users; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <?php
                        $select_messages = $conn->prepare("SELECT * FROM `messages`");
                        $select_messages->execute();
                        $number_of_messages = $select_messages->rowCount()
                    ?>
                    <span class="info-box-icon bg-success elevation-1"><i class="bi bi-envelope-fill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Messages</span>
                        <span class="info-box-number"><?= $number_of_messages; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="../js/index.js"></script>
    <script src="../js/admin_script.js"></script>
    <script src="../js/carousel.js"></script>
    <script src="../js/input.js"></script>
    <script src="../js/app.min.js"></script>
    <script src="../js/admin_script.js"></script>
</body>
</html>