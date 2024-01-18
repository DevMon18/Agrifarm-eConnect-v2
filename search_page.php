<?php

require_once 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

require_once 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>
   <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
   <?php require_once 'components/user_header.php'; ?>
   <div class="container mt-5 mb-5">
      <div class="row justify-content-center">
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <div class="text-center mb-4">
                     <h3>Search Product</h3>
                  </div>
                  <form action="" method="post">
                     <div class="input-group mb-3">
                        <input type="text" name="search_box" placeholder="search here..." class="form-control" required>
                        <button type="submit" class="btn btn-primary" name="search_btn"><i class="bi bi-search"></i></button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   <section class="products" style="padding-top: 0; min-height:100vh;">

      <div class="box-container">

         <?php
         if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <form action="" method="post" class="box">
                     <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                     <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                     <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                     <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                     <button class="bi bi-heart-fill" type="submit" name="add_to_wishlist"></button>
                     <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="bi bi-eye-fill"></a>
                     <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                     <div class="name">
                        <?= $fetch_product['name']; ?>
                     </div>
                     <div class="flex">
                        <div class="price"><span>₱</span>
                           <?= $fetch_product['price']; ?><span>/-</span>
                        </div>
                        <input type="number" name="qty" class="form-control" style="width: 60px;" min="1" max="99"
                           onkeypress="if(this.value.length == 2) return false;" value="1">
                     </div>
                     <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                  </form>
                  <?php
               }
            } else {
               echo '<p class="empty">no products found!</p>';
            }
         }
         ?>
      </div>
   </section>
   <?php require_once 'components/footer.php'; ?>
   <script src="js/script.js"></script>
</body>

</html>