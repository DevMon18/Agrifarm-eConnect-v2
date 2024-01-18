<?php

require_once 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us</title>
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
   <section class="about">
      <div class="row">
         <div class="col">
            <div class="image">
               <img src="images/about-img.svg" class="img-fluid w-full h-full" alt="">
            </div>
         </div>
         <div class="content">
            <h3 class="text-dark text-capitalize">why choose us?</h3>
            <p class="text-">Choose Agrifarm Econnect for sustainable agriculture, direct producer connection, convenient online shopping, community engagement, enhanced food security, transparency, and support for farm school education.</p>
            <a href="contact.php" class="btn btn-primary">Contact us</a>
         </div>
      </div>
   </section>
   <?php require_once 'components/footer.php'; ?>
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <script src="js/script.js"></script>
   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            768: {
               slidesPerView: 2,
            },
            991: {
               slidesPerView: 3,
            },
         },
      });

   </script>

</body>

</html>