<?php

require_once 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders-Agri</title>
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

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   
   <div class="box">
      <h6 class="text-dark">Placed on : <span><?= $fetch_orders['placed_on']; ?></span></h6>
      <h6 class="text-dark">Name : <span><?= $fetch_orders['name']; ?></span></h6>
      <h6 class="text-dark">Email : <span><?= $fetch_orders['email']; ?></span></h6>
      <h6 class="text-dark">Number : <span><?= $fetch_orders['number']; ?></span></h6>
      <h6 class="text-dark">Address : <span><?= $fetch_orders['address']; ?></span></h6>
      <h6 class="text-dark">Your orders : <span><?= $fetch_orders['total_products']; ?></span></h6>
      <h6 class="text-dark">Total price : <span>₱<?= $fetch_orders['total_price']; ?></span></h6>
      <h6 class="text-dark">Parcel & Payment status:
    <span style="color:<?php if($fetch_orders['payment_status'] == 'Pending'){ echo 'red'; }else{ echo 'green'; }; ?>">
        <?= $fetch_orders['payment_status']; ?></h6>
    </span>
    <br>
   <span><h6 style="color:purple; margin:0">Parcel Tracking:</h6>
               <?php
            if ($fetch_orders['payment_status'] == 'Delivering') {
               echo '<span class="text-primary">Processed</span>';
            }
            if ($fetch_orders['payment_status'] == 'Arriving') {
               echo '<span class="text-primary">Processed</span> • <span class="text-warning">Delivered</span>';
            }
            if ($fetch_orders['payment_status'] == 'Completed') {
               echo '<span class="text-primary">Processed</span> • <span class="text-warning">Delivered</span> • <span class="text-purple">Arrived</span>';
            }
            ?>
      </span> 
      </div>
         
      <?php
         }
            }else{
               echo '<p class="empty">no orders placed yet!</p>';
            }
         }
      ?>

   </div>

</section>

<?php require_once 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>