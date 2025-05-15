<?php

require_once 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
}

require_once 'components/wishlist_cart.php';
require_once 'components/count_items.php';

$response = []; 

if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $response = [
      'icon' => 'success',
      'title' => 'Successfully Deleted!',
   ];
}

if (isset($_GET['delete_all'])) {
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
   $response = [
      'icon' => 'success',
      'title' => 'Successfully Deleted!',
   ];
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $response = [
      'icon' => 'success',
      'title' => 'Quantity Updated!',
   ];
}

$responseJSON = json_encode($response);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
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
   <section class="products shopping-cart">
      <h3 class="heading">shopping cart</h3>
      <div class="box-container">
         <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <form action="" method="post" class="box">
                  <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                  <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="bi bi-eye-fill"></a>
                  <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                  <h3 class="text-dark name">
                     <?= $fetch_cart['name']; ?>
                  </h3>
                  <div class="flex">
                     <h5 class="text-primary price">₱
                        <?= $fetch_cart['price']; ?>
                     </h5>
                     <input type="number" name="qty" class="form-control" style="width: 60px;" min="1" max="99"
                        onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>" required>
                     <button type="submit" class="btn btn-primary" name="update_qty"><i class="bi bi-pen-fill"></i></button>
                  </div>
                  <h5 class="text-dark sub-total"> Subtotal : <span class="text-primary">₱
                        <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                     </span></h5>
                  <button type="submit" class="btn btn-danger" name="delete"
                     onclick="return confirm('delete this from cart?');">Delete Item</button>
               </form>
               <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty">your cart is empty</p>';
         }
         ?>
      </div>
      <hr>
      <div class="container mt-5 mb-5">
         <div class="row justify-content-center">
            <div class="col-md-4">
               <div class="card">
                  <div class="card-body">
                     <p>Grand Total : <span>₱
                           <?= $grand_total; ?>
                        </span></p>
                     <div class="d-grid gap-2">
                        <a href="shop.php" class="btn btn-outline-secondary">Continue shopping</a>
                        <a href="cart.php?delete_all"
                           class="btn btn-danger <?= ($grand_total > 1) ? '' : 'disabled'; ?>"
                           onclick="return confirm('delete all from cart?');">Delete all item</a>
                        <a href="checkout.php"
                           class="btn btn-primary <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to checkout</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
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
            }
      };
      showAlert(response);
   </script>
</body>

</html>