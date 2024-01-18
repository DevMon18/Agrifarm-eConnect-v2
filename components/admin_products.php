<?php

require_once '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location: admin_login.php');
    exit;
}

if (isset($_POST['add_product'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
    $details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_STRING);

    $image_01 = $_FILES['image_01']['name'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/' . $image_01;

    $image_02 = $_FILES['image_02']['name'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/' . $image_02;

    $image_03 = $_FILES['image_03']['name'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/' . $image_03;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $response = [
            'icon' => 'error',
            'title' => 'Error',
            'text' => 'Product Already Exists!',
        ];
    } else {
        $insert_products = $conn->prepare("INSERT INTO `products` (name, details, price, image_01, image_02, image_03) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03]);

        if ($insert_products) {
            $max_image_size = 2000000; // Maximum image size in bytes

            if ($_FILES['image_01']['size'] > $max_image_size || $_FILES['image_02']['size'] > $max_image_size || $_FILES['image_03']['size'] > $max_image_size) {
                $response = [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Image size is too large!',
                ];
            } else {
                move_uploaded_file($image_tmp_name_01, $image_folder_01);
                move_uploaded_file($image_tmp_name_02, $image_folder_02);
                move_uploaded_file($image_tmp_name_03, $image_folder_03);
                $response = [
                    'icon' => 'success',
                    'title' => 'Success',
                    'text' => 'New Product Added!',
                ];
            }
        }
    }

    $responseJSON = json_encode($response);
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);

    unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_03']);

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);

    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);

    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);

    header('Location: products1.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/index.min.css">
    <link rel="stylesheet" href="../css/image.css">
       <style>
        .card {
            height: 100%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed antialiased">
        <!-- Customize page header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>Add Products</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Customize page content -->
        <form action="" class="form-horizontal h6" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 d-flex align-items-stretch flex-column">
                        <div class="card shadow rounded-lg">
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Price</label>
                                                <input type="number" class="form-control" name="price"
                                                    class="form-control"
                                                    oninput="this.value = this.value.replace(/\s/g, '')" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-2">
                                                <label class="h6" for="main-photo">Photo 1</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image_01" class="custom-file-input"
                                                        id="image-1" required>
                                                    <label class="custom-file-label" for="main-photo">Choose Photo
                                                        1</label>
                                                </div>
                                                <div id="show-1" class="image-show"></div>
                                            </div>
                                        </div>

                                        <!-- Venue photo 1 -->
                                        <div class="col">
                                            <div class="mb-2">
                                                <label class="h6" for="photo-1">Photo 2</label>
                                                <div class="custom-file">
                                                    <input type="file" name="image_02" class="custom-file-input"
                                                        id="image-2">
                                                    <label class="custom-file-label" for="photo-1">Choose Photo
                                                        2</label>
                                                </div>
                                                <div id="show-2" class="image-show"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="h6" for="photo-1">Photo 3</label>
                                        <div class="custom-file">
                                            <input type="file" name="image_03" class="custom-file-input" id="image-3"
                                                >
                                            <label class="custom-file-label" for="photo-1">Choose Photo 3</label>
                                        </div>
                                        <div id="show-3" class="image-show"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Description</label>
                                        <textarea class="form-control" name="details"></textarea>
                                    </div>
                                    <button type="submit" name="add_product" class="btn btn-block btn-primary">Add
                                        Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        </div>
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h3>Items</h3>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid">
                        <div class="row ">
                                <?php
                                $select_products = $conn->prepare("SELECT * FROM `products`");
                                $select_products->execute();
                                if ($select_products->rowCount() > 0) {
                                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                    <div class="col-md-3 d-flex align-items-stretch flex-column">
                                        <div class="card-body card shadow rounded-lg">
                                            <div class="mb-3">
                                                <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" class="img-fluid rounded-lg" alt="">
                                            </div>
                                            <h4 class="mb-3 name"><?= $fetch_products['name']; ?></h4>
                                            <p class="text-primary price">₱<span><?= $fetch_products['price']; ?></span></p>
                                            <p class="details"><span><?= $fetch_products['details']; ?></span></p>
                                            <!-- Update button -->
                                            <div class="text-center mt-2 mb-2">
                                                <a href="update_product1.php?update=<?= $fetch_products['id']; ?>" type="submit" class="btn btn-block btn-primary">Update</a>
                                                <a href="products1.php?delete=<?= $fetch_products['id']; ?>" type="submit" class="btn btn-block btn-danger">Delete</a>
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
                </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
            integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
        <script src="../js/admin_script.js"></script>
        <script src="../js/carousel.js"></script>
        <script src="../js/index.js"></script>
        <script src="../js/input.js"></script>
        <script src="../js/image.js"></script>
        <script src="../js/app.min.js"></script>
        <script src="../js/admin_script.js"></script>
        <script>
        const response = <?php echo $responseJSON; ?>;
        const showAlert = (response) => {
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
        };
        showAlert(response);
    </script>
</body>

</html>