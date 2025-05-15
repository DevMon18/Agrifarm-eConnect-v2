<?php

require_once 'components/header.php';
require_once 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

require_once 'components/wishlist_cart.php';
require_once 'components/count_items.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AgriFarm - Your Fresh Food Market</title>
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php require_once 'components/user_header.php'; ?>

   <!-- Hero Section with Parallax -->
   <div class="hero-section py-5 bg-light parallax-window">
      <div class="container">
         <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 shadow-sm">
               <div class="carousel-item active">
                  <div class="parallax-bg" style="background-image: url('images/caro-item4.png');">
                     <div class="carousel-caption">
                        <h2 data-aos="fade-up">Fresh from the Farm</h2>
                        <p data-aos="fade-up" data-aos-delay="200">Quality agricultural products delivered to your doorstep</p>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="parallax-bg" style="background-image: url('images/caro-item5.png');">
                     <div class="carousel-caption">
                        <h2 data-aos="fade-up">100% Organic</h2>
                        <p data-aos="fade-up" data-aos-delay="200">Naturally grown fruits and vegetables</p>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="parallax-bg" style="background-image: url('images/caro-item6.png');">
                     <div class="carousel-caption">
                        <h2 data-aos="fade-up">Direct from Farmers</h2>
                        <p data-aos="fade-up" data-aos-delay="200">Supporting local agriculture</p>
                     </div>
                  </div>
               </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Next</span>
            </button>
         </div>
      </div>
   </div>

   <!-- Featured Categories -->
   <section class="categories py-5">
      <div class="container">
         <h2 class="text-center mb-4" data-aos="fade-up">Shop by Category</h2>
         <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
               <div class="category-card text-center p-4 rounded-4 shadow-sm">
                  <i class="bi bi-flower3 display-4 text-primary mb-3"></i>
                  <h4>Vegetables</h4>
                  <p>Fresh, locally sourced vegetables</p>
               </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
               <div class="category-card text-center p-4 rounded-4 shadow-sm">
                  <i class="bi bi-tree display-4 text-success mb-3"></i>
                  <h4>Fruits</h4>
                  <p>Seasonal and exotic fruits</p>
               </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
               <div class="category-card text-center p-4 rounded-4 shadow-sm">
                  <i class="bi bi-droplet display-4 text-info mb-3"></i>
                  <h4>Organic</h4>
                  <p>Certified organic products</p>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-- Latest Products -->
   <section class="latest-products py-5 bg-light">
      <div class="container">
         <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" data-aos="fade-right">Latest Products</h2>
            <a href="shop.php" class="btn btn-outline-primary" data-aos="fade-left">View All</a>
         </div>
         
         <div class="row g-4">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC LIMIT 8");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               $delay = 0;
               while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                  $delay += 100;
            ?>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
               <div class="card product-card h-100 border-0 shadow-sm">
                  <div class="position-relative">
                     <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" class="card-img-top" alt="<?= $fetch_product['name']; ?>">
                     <div class="product-overlay">
                        <form action="" method="post">
                           <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                           <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                           <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                           <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                           <button type="submit" name="add_to_wishlist" class="btn btn-light btn-sm rounded-circle">
                              <i class="bi bi-heart"></i>
                           </button>
                           <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="btn btn-light btn-sm rounded-circle">
                              <i class="bi bi-eye"></i>
                           </a>
                        </form>
                     </div>
                  </div>
                  <div class="card-body">
                     <h5 class="card-title"><?= $fetch_product['name']; ?></h5>
                     <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-primary mb-0">₱<?= $fetch_product['price']; ?></h6>
                        <form action="" method="post">
                           <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                           <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                           <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                           <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                           <input type="hidden" name="qty" value="1">
                           <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                              Add to Cart
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <?php
               }
            } else {
               echo '<p class="text-center">No products available yet!</p>';
            }
            ?>
         </div>
      </div>
   </section>

   <!-- Features Section -->
   <section class="features py-5">
      <div class="container">
         <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
               <div class="feature-card text-center p-4">
                  <i class="bi bi-truck display-4 text-primary mb-3"></i>
                  <h5>Free Delivery</h5>
                  <p class="mb-0">On orders above ₱1000</p>
               </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
               <div class="feature-card text-center p-4">
                  <i class="bi bi-shield-check display-4 text-primary mb-3"></i>
                  <h5>Fresh & Safe</h5>
                  <p class="mb-0">100% guaranteed</p>
               </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
               <div class="feature-card text-center p-4">
                  <i class="bi bi-credit-card display-4 text-primary mb-3"></i>
                  <h5>Secure Payment</h5>
                  <p class="mb-0">100% secure payment</p>
               </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
               <div class="feature-card text-center p-4">
                  <i class="bi bi-headset display-4 text-primary mb-3"></i>
                  <h5>24/7 Support</h5>
                  <p class="mb-0">Dedicated support</p>
               </div>
            </div>
         </div>
      </div>
   </section>

   <?php require_once 'components/footer.php'; ?>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   <script src="js/script.js"></script>
   <script>
      // Initialize AOS
      AOS.init({
         duration: 800,
         easing: 'ease-in-out',
         once: true,
         mirror: false
      });

      // Parallax effect
      window.addEventListener('scroll', function() {
         const parallax = document.querySelectorAll('.parallax-bg');
         let scrollPosition = window.pageYOffset;
         
         parallax.forEach(bg => {
            bg.style.transform = 'translateY(' + scrollPosition * 0.5 + 'px)';
         });
      });
   </script>
</body>

</html>