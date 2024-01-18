<?php

require_once 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

require_once 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wishlist</title>
   <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>
   
<?php require_once 'components/user_header.php'; ?>

<section class="products">
   <h3 class="heading">Your Wishlist</h3>
   <div class="container">
      <div class="box-container">
         <?php
            $grand_total = 0;
            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $select_wishlist->execute([$user_id]);
            if ($select_wishlist->rowCount() > 0) {
               while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                  $grand_total += $fetch_wishlist['price'];
         ?>
         <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
            <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
            <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
            <div class="name"><?= $fetch_wishlist['name']; ?></div>
            <div class="flex">
               <div class="price">₱<?= $fetch_wishlist['price']; ?>/-</div>
               <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
               
            </div> 
            <input type="submit" value="Add to Cart" class="btn btn-primary" name="add_to_cart">
            <input type="submit" value="Delete Item" onclick="return confirm('Delete this from the wishlist?');" class="delete-btn btn btn-danger" name="delete">
         </form>
         <?php
               }
            } else {
               echo '<p class="empty">Your wishlist is empty</p>';
            }
         ?>
      </div>
      <div class="wishlist-total">
         <p>Grand Total: <span>$<?= $grand_total; ?>/-</span></p>
         <a href="shop.php" class="option-btn btn btn-primary">Continue Shopping</a>
         <a href="wishlist.php?delete_all" class="delete-btn btn btn-danger <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all from the wishlist?');">Delete All Items</a>
      </div>
   </div>
</section>
<?php require_once 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>