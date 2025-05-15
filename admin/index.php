<?php

require_once '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($select_admin->rowCount() > 0) {
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard1.php');
   } else {
      $response = [
         'icon' => 'error',
         'title' => 'Authentication Failed',
         'text' => 'Incorrect username or password!',
      ];
   }
   $responseJSON = json_encode($response);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login - AgriFarm</title>
   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      body {
         background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .login-card {
         background: #ffffff;
         border-radius: 20px;
         box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
         max-width: 440px;
         width: 90%;
         padding: 3rem;
      }
      .login-header {
         text-align: center;
         margin-bottom: 2.5rem;
      }
      .login-header .shield-icon {
         width: 48px;
         height: 48px;
         margin-bottom: 1.5rem;
         color: #21a67a;
      }
      .login-header h2 {
         font-size: 28px;
         font-weight: 600;
         color: #2c3345;
         margin-bottom: 0.5rem;
      }
      .login-header p {
         color: #6b7280;
         font-size: 16px;
         margin-bottom: 0;
      }
      .input-wrapper {
         position: relative;
         margin-bottom: 1.25rem;
      }
      .input-wrapper .input-icon {
         position: absolute;
         left: 16px;
         top: 50%;
         transform: translateY(-50%);
         color: #9ca3af;
         font-size: 1.25rem;
         z-index: 1;
      }
      .form-control {
         width: 100%;
         padding: 0.875rem 1rem 0.875rem 3rem;
         font-size: 1rem;
         line-height: 1.5;
         color: #2c3345;
         background-color: #fff;
         border: 1px solid #e5e7eb;
         border-radius: 8px;
         transition: all 0.2s ease;
      }
      .form-control::placeholder {
         color: #9ca3af;
      }
      .form-control:focus {
         border-color: #21a67a;
         box-shadow: 0 0 0 4px rgba(33, 166, 122, 0.1);
         outline: none;
      }
      .btn-login {
         width: 100%;
         padding: 0.875rem;
         font-size: 1rem;
         font-weight: 500;
         background: #21a67a;
         border: none;
         border-radius: 8px;
         color: white;
         display: flex;
         align-items: center;
         justify-content: center;
         gap: 0.5rem;
         transition: all 0.2s ease;
         margin-top: 2rem;
      }
      .btn-login:hover {
         background: #1a8562;
         transform: translateY(-1px);
      }
      .btn-login:active {
         transform: translateY(0);
      }
   </style>
</head>
<body>

<div class="login-card">
   <div class="login-header">
      <svg class="shield-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
         <path d="M12 22C12 22 20 18 20 12V5L12 2L4 5V12C4 18 12 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
         <path d="M12 8V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
         <circle cx="12" cy="16" r="1" fill="currentColor"/>
      </svg>
      <h2>Admin Login</h2>
      <p>Welcome back! Please login to your account.</p>
   </div>

   <form action="" method="post">
      <div class="input-wrapper">
         <i class="bi bi-person input-icon"></i>
         <input type="text" name="name" class="form-control" placeholder="Enter your username" required maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
      </div>

      <div class="input-wrapper">
         <i class="bi bi-key input-icon"></i>
         <input type="password" name="pass" class="form-control" placeholder="Enter your password" required maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
      </div>

      <button type="submit" name="submit" class="btn btn-login">
         LOGIN
         <i class="bi bi-arrow-right"></i>
      </button>
   </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   <?php if(isset($responseJSON)): ?>
   const response = <?php echo $responseJSON; ?>;
            Swal.fire({
               icon: response.icon,
               title: response.title,
      text: response.text,
      confirmButtonColor: '#21a67a'
   });
   <?php endif; ?>
</script>

</body>
</html>