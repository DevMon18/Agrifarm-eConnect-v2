<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AgriFarm Login</title>
   <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
   <link rel="stylesheet" href="css/check.css">

   <style>
      body {
         background-color: #f8f9fa;
      }
      .container{
         margin:0 auto;
         padding:0;
      }

      .card {
         border: none;
         box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);

      }

      .card-body {
         padding: 20px;
      }
      .form-label {
         font-weight: bold;
      }

      .password {
         position: relative;
      }

      .toggle-password {
         position: absolute;
         right: 10px;
         top: 50%;
         transform: translateY(-50%);
         cursor: pointer;
      }

      .mt-3 a {
         color: #999;
      }

      .mt-3 a:hover {
         color: blue;
      }
      .svg{
         margin:-2.2rem auto;
         z-index: -1;
         position: absolute;
      }
   </style>
</head>

<body>
  
      <div class="container mt-5">
         <div class="row align-items-center justify-content-center">
            <div class="col-md-4">
               <?php
               if (isset($_SESSION['status'])) {
                  ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <h5><?= $_SESSION['status']; ?></h5>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
               <?php
                  unset($_SESSION['status']);
               }
               ?>
               <div class="card">
                  <div class="card-body w-200">
                     <div class="text-center mb-2">
                     <img src="./images/logo.jpg" alt="Logo" style="border-radius:50px; height: 5em; width: 5em; vertical-align: middle; ">
                     </div>
                     <form action="login.php" method="post">
                        <div class="mb-3">
                           <label for="exampleInputEmail1" class="form-label">Email address</label>
                           <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                           <label for="exampleInputPassword1" class="form-label">Password</label>
                           <div class="password">
                              <input type="password" class="form-control" name="password" id="password" required>
                              <i class="bi bi-eye-slash toggle-password"></i>
                           </div>
                        </div>
                        <h6><a href="find.php" class="text-decoration-none">Forgot Password?</a></h6>
                        <div class="d-grid gap-2">
                           <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                        </div>
                        <div class="text-center mt-3">
                           <h6>Don't have an account? <a class="text-decoration-none" href="user_register.php">Register now</a></h6><br>
                           <h6><a class="text-decoration-none" href="index.php">Back to Homepage</a></h6>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

   <script src="js/password.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
   const passwordInput = document.getElementById('password');
   const togglePassword = document.querySelector('.toggle-password');

   togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      if (type === 'password') {
         togglePassword.classList.remove('bi-eye');
         togglePassword.classList.add('bi-eye-slash');
      } else {
         togglePassword.classList.remove('bi-eye-slash');
         togglePassword.classList.add('bi-eye');
      }
   });
</script>
<svg class="svg" id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 190" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(62, 243, 76.819, 1)" offset="0%"></stop><stop stop-color="rgba(11, 255, 245.907, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,152L10,148.8C20,146,40,139,60,114C80,89,100,44,120,41.2C140,38,160,76,180,82.3C200,89,220,63,240,53.8C260,44,280,51,300,50.7C320,51,340,44,360,47.5C380,51,400,63,420,79.2C440,95,460,114,480,114C500,114,520,95,540,72.8C560,51,580,25,600,22.2C620,19,640,38,660,47.5C680,57,700,57,720,76C740,95,760,133,780,142.5C800,152,820,133,840,126.7C860,120,880,127,900,123.5C920,120,940,108,960,114C980,120,1000,146,1020,142.5C1040,139,1060,108,1080,79.2C1100,51,1120,25,1140,25.3C1160,25,1180,51,1200,66.5C1220,82,1240,89,1260,95C1280,101,1300,108,1320,101.3C1340,95,1360,76,1380,63.3C1400,51,1420,44,1430,41.2L1440,38L1440,190L1430,190C1420,190,1400,190,1380,190C1360,190,1340,190,1320,190C1300,190,1280,190,1260,190C1240,190,1220,190,1200,190C1180,190,1160,190,1140,190C1120,190,1100,190,1080,190C1060,190,1040,190,1020,190C1000,190,980,190,960,190C940,190,920,190,900,190C880,190,860,190,840,190C820,190,800,190,780,190C760,190,740,190,720,190C700,190,680,190,660,190C640,190,620,190,600,190C580,190,560,190,540,190C520,190,500,190,480,190C460,190,440,190,420,190C400,190,380,190,360,190C340,190,320,190,300,190C280,190,260,190,240,190C220,190,200,190,180,190C160,190,140,190,120,190C100,190,80,190,60,190C40,190,20,190,10,190L0,190Z"></path></svg>
</body>

</html>