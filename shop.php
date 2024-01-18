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
   <title>Shop-Agri</title>
   <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<style>
   .box-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(3, auto);
      gap: 20px;
   }
   
   .box {
      padding: 20px;
      /* Add any other desired styling properties */
   }
</style>
<body>

   <?php require_once 'components/user_header.php'; ?>

   <section class="home-products">
      <h1 class="text-dark text-center">Latest Products</h1>
      <div class="box-container">
         <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
               
               <form action="" method="post" class="box swiper-slide slide" style="width: 400px; padding: 20px; ">
                  <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                  <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                  <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                  <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                  <button class="bi bi-heart-fill" type="submit" name="add_to_wishlist"></button>
                  <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="bi bi-eye-fill"></a>
                  <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                  <h3 class="text-dark name">
                     <?= $fetch_product['name']; ?>
                  </h3>
                  <div class="flex">
                     <h5 class="text-primary price"><span>₱</span>
                        <?= $fetch_product['price']; ?><span>/kg</span>
                     </h5>
                     <input type="number" name="qty" class="form-control" style="width: 60px;" min="1" max="99"
                        onkeypress="if(this.value.length == 2) return false;" value="1">
                  </div>
                  <button type="submit" class="btn btn-primary mt-3" name="add_to_cart">Add to Cart</button>
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no products found!</p>';
         }
         ?>

      </div>

   </section>
   <?php require_once 'components/footer.php'; ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="js/script.js"></script>
   <script>
      const response = <?php echo $responseJSON; ?>;

      const showAlert = (response) => {
         switch (response.icon) {
            case 'success':
               Swal.fire({
                  icon: response.icon,
                  title: response.title
               });
               break;
            case 'error':
               Swal.fire({
                  icon: response.icon,
                  title: response.title,
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