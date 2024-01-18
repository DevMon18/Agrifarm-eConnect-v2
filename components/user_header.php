<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header" style="background-color:#132a13;">

   <section class="flex " style="background-color:#132a13;">
      <a href="index.php" class="logo text-decoration-none"><img src="./images/logo.jpg" alt="Logo" style="border-radius:25px; height: 3em; width: 3em; vertical-align: middle; margin-right: 10px;">Agrifarm e-Connect<span></span></a>

      <nav class="navbar">
         <a href="index.php" class="text-decoration-none">Home</a>
         <a href="shop.php" class="text-decoration-none">Shop</a>
         <a href="orders.php" class="text-decoration-none">Orders</a>
         <a href="about.php" class="text-decoration-none">About</a>
         <a href="contact.php" class="text-decoration-none">Contact us</a>
      </nav>

      <div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();

            if (isset($_SESSION['update_button_count'])) {
               $clickCount = $_SESSION['update_button_count'];
           } else {
               $clickCount = 0;
           }
         ?>
         <div id="menu-btn" class="bi bi-list"></div>
         <a href="search_page.php" class="text-decoration-none"><i class="bi bi-search"></i></a>
         <a href="wishlist.php" class="text-decoration-none"><i class="bi bi-heart-fill"></i><span> <?= $total_wishlist_counts; ?></span></a>
         <a href="cart.php" class="text-decoration-none"><i class="bi bi-cart-check-fill"></i><span> <?= $total_cart_counts; ?></span></a>
              <a href="orders.php" class="text-decoration-none">
            <i class="bi bi-bell"></i>
            <span id="notification-counter" class="notification-counter"><?php echo $clickCount; ?></span>
        </a>
      
   <a id="user-btn" class="bi bi-person-fill"></a>
</div>

      <div class="card rounded-lg w-25">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         
         <h6 class="text-dark text-center mb-3"><?= $fetch_profile["name"]; ?></h6>
         <div class="d-grid gap-2">
            <a href="update_user.php" class="btn btn-primary">Update Profile</a>
            <a href="components/user_logout.php" class="btn btn-danger" onclick="return confirm('logout from the website?');">Logout</a> 
         </div>
         <?php
            }else{
         ?>
         <h6 class="text-dark text-center mb-3">Please login or register first!</h6>
         <div class="d-grid gap-2">
            <a href="user_register.php" class="btn btn-primary">Sign Up</a>
            <a href="user_login.php" class="btn btn-outline-secondary">Login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>