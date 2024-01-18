<?php

require_once '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:index.php');
}

$response = null; // Initialize the response variable

if (isset($_POST['update_payment'])) {
    if (!isset($_SESSION['update_button_count'])) {
        $_SESSION['update_button_count'] = 1;
    } else {
        $_SESSION['update_button_count']++;
    }
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
    $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment->execute([$payment_status, $order_id]);

    // Set the response message
    $response = [
        'icon' => 'success',
        'title' => 'Success',
        'text' => 'Payment Status Updated!',
    ];
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders1.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/index.min.css">
    <link rel="stylesheet" href="../css/image.css">
</head>
    <body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed antialiased">
<!-- Customize page header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Placed Orders</h3>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid">
    <div class="row ">
        <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
        ?>
            <div class="col-md-3 d-flex align-items-stretch flex-column">
                <div class="card-body card shadow rounded-lg">
                    <h6>Place on: <span><?= $fetch_orders['placed_on']; ?></span> </h6>
                    <h6>Name: <span><?= $fetch_orders['name']; ?></span> </h6>
                    <h6>Contact No: <span><?= $fetch_orders['number']; ?></span> </h6>
                    <h6>Address: <span><?= $fetch_orders['address']; ?></span> </h6>
                    <h6>Total Products: <span><?= $fetch_orders['total_products']; ?></span> </h6>
                    <h6>Total Price: <span>₱<?= $fetch_orders['total_price']; ?></span> </h6>
                    <h6>Payment Method: <span><?= $fetch_orders['method']; ?></span> </h6>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <div class="form-group">
                        <label>Select Multiple</label>
                        <select name="payment_status" class="form-control">
                            <option selected><?= $fetch_orders['payment_status']; ?></option>
                                <option>Processing</option>
                                <option>Delivering</option>
                                <option>Arriving</option>
                                <option>Completed</option>
                            </select>
                        </div>
                            <button type="submit" name="update_payment" class="btn btn-block btn-primary">Update</button>
                            <a href="placed_orders1.php?delete=<?= $fetch_orders['id']; ?>" class="btn btn-block btn-danger" onclick="return confirm('delete this order?');">delete</a>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                }
                    } else {
                         echo '<p class="text-center ml-4">No products added yet!</p>';
                        }
                    ?>
                </div>
            </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        const response = <?php echo json_encode($response); ?>;
        if (response) {
            switch (response.icon) {
                case 'success':
                    Swal.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.text
                    });
                    break;
                case 'error':
                    Swal.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.text
                    });
                    break;
                default:
                    alert(response.text);
                    break;
            }
        }
    });
</script>
</body>
</html>