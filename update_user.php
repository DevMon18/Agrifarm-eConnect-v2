<?php

require_once 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, address = ?, number = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $address, $number, $user_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if ($old_pass == $empty_pass) {
      $response = [
         'icon' => 'error',
         'title' => 'Please Enter Old Password!',
      ];
   } elseif ($old_pass != $prev_pass) {
      $response = [
         'icon' => 'error',
         'title' => 'Old Password not Matched!',
      ];
   } elseif ($new_pass != $cpass) {
      $response = [
         'icon' => 'error',
         'title' => 'Username Already Exist!',
      ];
   } else {
      if ($new_pass != $empty_pass) {
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $response = [
            'icon' => 'success',
            'title' => 'Password Update Successfully!',
         ];
      } else {
         $response = [
            'icon' => 'error',
            'title' => 'Please Enter A New Password!',
         ];
      }
   }
   $responseJSON = json_encode($response);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
   <link rel="stylesheet" href="css/check.css">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php require_once 'components/user_header.php'; ?>
      <div class="container mt-5 mb-5">
         <div class="row justify-content-center">
            <div class="col-md-6">
               <div class="card">
                  <div class="card-body">
                     <div class="text-center mb-4">
                        <h3>Update Profile</h3>
                     </div>
                     <form action="" method="post">
                     <div class="mb-3">
                        <input type="hidden" class="form-control" name="prev_pass" value="<?= $fetch_profile["password"]; ?>" placeholder="Name" class="form-control">
                     </div>
                     <div class="row">
                        <div class="col">
                           <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" value="<?= $fetch_profile["name"]; ?>" placeholder="Name" class="form-control">
                           </div>
                        </div>
                           <div class="col">
                              <div class="mb-3">
                                 <label for="exampleInputPassword1" class="form-label">Email</label>
                                 <input type="email" class="form-control" name="email" value="<?= $fetch_profile["email"]; ?>" placeholder="Email"  class="form-control" oninput="this.value = this.value.replace(/\s/g, '')" required>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                        <div class="col">
                           <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Address</label>
                              <input type="text" class="form-control" name="address" value="<?= $fetch_profile["address"]; ?>" placeholder="Address" class="form-control" required>
                           </div>
                        </div>
                           <div class="col">
                              <div class="mb-3">
                                 <label for="exampleInputPassword1" class="form-label">Contact No</label>
                                 <input type="number" name="number" value="<?= $fetch_profile["number"]; ?>" placeholder="09*********" class="form-control" required>
                              </div>
                           </div>
                        </div>
                        <div class="mb-3">
                           <label for="exampleInputEmail1" class="form-label">Old Password</label>
                           <input type="password" name="old_pass" placeholder="Enter Old Password" maxlength="20"  class="form-control password" oninput="this.value = this.value.replace(/\s/g, '')" required>
                        </div>
                        <div class="mb-3">
                           <label for="exampleInputEmail1" class="form-label">New Password</label>
                           <input type="password" name="new_pass" placeholder="Enter New Password" maxlength="20"  class="form-control password" oninput="this.value = this.value.replace(/\s/g, '')" required>
                        </div>
                        <div class="mb-3">
                           <label for="exampleInputPassword1" class="form-label">Retype-password</label>
                           <input type="password" name="cpass" placeholder="Retype-password" maxlength="20" class="form-control password" oninput="this.value = this.value.replace(/\s/g, '')" required>
                        </div>
                        <div class="icheck-primary mt-3">
                           <input type="checkbox" class="show toggle-password form-check-input" id="toggle-password" style="cursor:pointer">
                           <label class="form-check-label" for="toggle-password">Show password</label>
                        </div>
                        <div class="d-grid gap-2">
                           <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   </section>
   <?php require_once 'components/footer.php'; ?>

   <script src="js/password.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
   <script src="js/script.js"></script>
   <script src="js/jquery.min.js"></script>
   <script src="js/app.min.js"></script>
   <script>
      const response = <?php echo $responseJSON; ?>;
      const showAlert = (response) => {
            switch (response.icon) {
               case 'success':
                  Swal.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.text
                  });
                  break;
               case 'error':
                  Swal.fire({
                        icon: response.icon,
                        title: response.title,
                        text: response.text
                  });
                  break;
               default:
                  alert(response.text);
                  break;
            }
         };
      showAlert(response);
   </script>
</body>
</html>