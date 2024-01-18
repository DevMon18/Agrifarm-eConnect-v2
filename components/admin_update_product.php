<?php

require_once '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update'])) {

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $pid]);

    $response = [
        'icon' => 'success',
        'title' => 'Success',
        'text' => 'Product updated successfully!',
    ];

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/' . $image_01;

    if (!empty($image_01)) {
        if ($image_size_01 > 2000000) {
            $response = [
                'icon' => 'error',
                'title' => 'error',
                'text' => 'Image size is too large!',
            ];
        } else {
            $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            unlink('../uploaded_img/' . $old_image_01);
            $response = [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Image 01 updated successfully!',
            ];
        }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/' . $image_02;

    if (!empty($image_02)) {
        if ($image_size_02 > 2000000) {
            $response = [
                'icon' => 'error',
                'title' => 'error',
                'text' => 'Image size is too large!',
            ];
        } else {
            $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            unlink('../uploaded_img/' . $old_image_02);
            $response = [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Image 02 updated successfully!',
            ];
        }
    }

    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/' . $image_03;

    if (!empty($image_03)) {
        if ($image_size_03 > 2000000) {
            $response = [
                'icon' => 'error',
                'title' => 'error',
                'text' => 'Image size is too large!',
            ];
        } else {
            $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            unlink('../uploaded_img/' . $old_image_03);
            $response = [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Image 03 updated successfully!',
            ];

            $responseJSON = json_encode($response);

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin update</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
                <h3>Update Products</h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-lg">
                <div class="card-body">
                    <?php
                    $update_id = $_GET['update'];
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$update_id]);
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
                                <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
                                <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">

                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>"
                                                class="img-fluid mt-1 rounded-lg" style="cursor:pointer" height="500px" alt="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Photo 1</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>"
                                                class="img-fluid mt-1 rounded-lg" style="cursor:pointer" height="500px" alt="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Photo 2</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>"
                                                class="img-fluid mt-1 rounded-lg" style="cursor:pointer" height="500px" alt="">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>Photo 3</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators"
                                        data-slide="prev">
                                        <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                                        <span class="sr-only">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators"
                                        data-slide="next">
                                        <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                                        <span class="sr-only">Next</span>
                                    </button>
                                </div>

                                <div class="row mt-4">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" value="<?= $fetch_products['name']; ?>"
                                                name="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Price</label>
                                            <input type="number" class="form-control" value="<?= $fetch_products['price']; ?>"
                                                name="price" class="form-control"
                                                oninput="this.value = this.value.replace(/\s/g, '')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Description</label>
                                    <textarea class="form-control" name="details" required><?= $fetch_products['details']; ?></textarea>
                                        </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-2">
                                            <label class="h6" for="main-photo">Photo 1</label>
                                            <div class="custom-file">
                                                <input type="file" name="image_01" class="custom-file-input" id="image-1"
                                                    required>
                                                <label class="custom-file-label" for="main-photo">Choose Photo 1</label>
                                            </div>
                                            <div id="show-1" class="image-show"></div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-2">
                                            <label class="h6" for="photo-1">Photo 2</label>
                                            <div class="custom-file">
                                                <input type="file" name="image_02" class="custom-file-input" id="image-2"
                                                    >
                                                <label class="custom-file-label" for="photo-1">Choose Photo 2</label>
                                            </div>
                                            <div id="show-2" class="image-show"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="h6" for="photo-1">Photo 3</label>
                                    <div class="custom-file">
                                        <input type="file" name="image_03" class="custom-file-input" id="image-3" >
                                        <label class="custom-file-label" for="photo-1">Choose Photo 3</label>
                                    </div>
                                    <div id="show-3" class="image-show"></div>
                                </div>
                                <button type="submit" name="update" class="btn btn-block btn-primary">Update Product</button>
                                <a href="products1.php" type="submit" name="add_product"
                                    class="btn btn-block btn-default">Back</a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
            } else {
                echo '<p class="text-center">no product found!</p>';
            }
        ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="../js/index.js"></script>
    <script src="../js/app.min.js"></script>
    <script src="../js/admin_script.js"></script>
    <script src="../js/carousel.js"></script>
    <script src="../js/input.js"></script>
    <script src="../js/image.js"></script>
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