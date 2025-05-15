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

<header class="header">
   <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
         <a href="index.php" class="navbar-brand">
            <i class="bi bi-flower1"></i> Agri<span>Farm</span>
         </a>
         
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="shop.php">Shop</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="orders.php">Orders</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="about.php">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact</a>
               </li>
            </ul>

            <form class="d-flex me-3" action="search_page.php" method="POST">
               <input class="form-control me-2" type="search" placeholder="Search products..." name="search_box">
               <button class="btn btn-outline-light" type="submit" name="search_btn">
                  <i class="bi bi-search"></i>
               </button>
            </form>

            <div class="icons d-flex align-items-center">
               <a href="wishlist.php" class="btn btn-link text-light position-relative me-2">
                  <i class="bi bi-heart-fill"></i>
                  <?php if($count_wishlist_items > 0): ?>
                     <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $count_wishlist_items ?>
                     </span>
                  <?php endif; ?>
               </a>
               
               <a href="cart.php" class="btn btn-link text-light position-relative me-2">
                  <i class="bi bi-cart-fill"></i>
                  <?php if($count_cart_items > 0): ?>
                     <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $count_cart_items ?>
                     </span>
                  <?php endif; ?>
               </a>

               <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <i class="bi bi-person-circle"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                     <?php if($user_id == ''): ?>
                        <li><a class="dropdown-item" href="user_register.php">Register</a></li>
                        <li><a class="dropdown-item" href="user_login.php">Login</a></li>
                     <?php else: ?>
                        <li><a class="dropdown-item" href="update_user.php">Update Profile</a></li>
                        <li><a class="dropdown-item" href="components/user_logout.php">Logout</a></li>
                     <?php endif; ?>
                  </ul>
</div>
         </div>
         </div>
      </div>
   </nav>
</header>