<?php

require_once 'components/connect.php';

session_start();


if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
}
;
$response = [];

$select_user_info = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user_info->execute([$user_id]);

if ($select_user_info->rowCount() > 0) {
   $user_data = $select_user_info->fetch(PDO::FETCH_ASSOC);
   $name = $user_data['name'];
   $email = $user_data['email'];
   $number = $user_data['number'];
   $address = $user_data['address'];
} else {
   $name = '';
   $email = '';
   $number = '';
   $address = '';
}

if (isset($_POST['order'])) {

   $name = $_POST['name'];
   $email = $_POST['email'];
   $address = $_POST['address'];
   $number = $_POST['number'];
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, email, address,  number, total_products, total_price) VALUES(?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $email, $address, $number, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $response = [
         'icon' => 'success',
         'title' => 'Order Place Successfully!'
      ];
   }

} else {
   $response = [
      'icon' => 'success',
      'title' => 'Added to Orders!'
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
   <title>Checkout</title>
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
   <form action="" method="POST">
      <div class="container mt-5 mb-5">
         <div class="row justify-content-center">
            <div class="col-md-9">
               <div class="card">
                  <div class="card-body">
                     <div class="d-grid gap-2">
                        <h1 class="text-center">Your Orders</h1>
                        <div class="display-orders">
                           <div class="row mt-4">
                              <div class="col">
                                 <?php
                                 $grand_total = 0;
                                 $cart_items[] = '';
                                 $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                 $select_cart->execute([$user_id]);
                                 if ($select_cart->rowCount() > 0) {
                                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                       $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') ';
                                       $total_products = implode($cart_items);
                                       $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                                       ?>
                                       <h5 class="text-dark mt-2">
                                          <?= $fetch_cart['name']; ?> <span class="text-primary">(
                                             <?= '₱' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity']; ?>)
                                          </span>
                                       </h5>
                                       <?php
                                    }
                                 } else {
                                    echo '<p class="empty">your cart is empty!</p>';
                                 }
                                 ?>
                                 <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                                 <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
                                 <h5 class="grand-total text-dark">Grand total : <span class="text-primary">₱
                                       <?= $grand_total; ?>
                                    </span></h5>
                              </div>

                              <div class="col">
                                 <img src="images/QR.jpg" class="img-fluid mb-4" style="height: 150px; width: 150px;">
                              </div>
                           </div>
                        </div>
                     </div>


                     <div class="row mt-4">
                        <div class="col">
                           <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Name</label>
                              <input type="text" class="form-control" name="name"
                                 value="<?= isset($name) ? htmlspecialchars($name) : ''; ?>" readonly>
                           </div>
                        </div>
                        <div class="col">
                           <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Email</label>
                              <input type="email" class="form-control" name="email"
                                 value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>"
                                 #oninput="this.value = this.value.replace(/\s/g, '')" required readonly>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col">
                           <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Address</label>
                              <input type="text" class="form-control" name="address"
                                 value="<?= isset($address) ? htmlspecialchars($address) : ''; ?>" required readonly>
                           </div>
                        </div>
                        <div class="col">
                           <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Contact No.</label>
                              <input type="number" name="number"
                                 value="<?= isset($number) ? htmlspecialchars($number) : ''; ?>" class="form-control"
                                 required readonly>
                           </div>
                        </div>
                        <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Reference No</label>
  <input type="number" name="number" id="numberInput" class="form-control" required>
</div>
<div class="input-group mb-3 mt-2">
  <label class="input-group-text" for="inputGroupSelect01">Payment</label>
  <select class="form-select" id="paymentSelect" required>
    <option selected>Choose...</option>
    <option value="cash on delivery">Cash on Delivery</option>
    <option value="Gcash_payment">Gcash</option>
  </select>
</div>
                     <div class="d-grid gap-2">
                        <button type="submit" name="order"
                           class="btn btn-primary <?= ($grand_total > 1) ? '' : 'readonly'; ?>">Place Order</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
   </form>
   <?php require_once 'components/footer.php'; ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="js/script.js"></script>
   <script>
  const response = <?php echo $responseJSON; ?>;

const showAlert = (response) => {
   const showAlertFlag = sessionStorage.getItem('showAlertFlag');

   if (!showAlertFlag) {
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
               title: response.title
            });
            break;
         default:
            alert(response.text);
            break;
      }

      sessionStorage.setItem('showAlertFlag', true);
   }
};

showAlert(response);
showAlert(response);

showAlert(response);

const paymentSelect = document.getElementById('paymentSelect');
const numberInput = document.getElementById('numberInput');

paymentSelect.addEventListener('change', function() {
   if (paymentSelect.value === 'cash on delivery') {
      numberInput.disabled = true;
      numberInput.readOnly = true;
      numberInput.value = ''; // Clear the number input field
   } else {
      numberInput.disabled = false;
      numberInput.readOnly = false;
   }
});
</script>
</body>

</html>