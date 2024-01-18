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
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $update_profile = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
    $update_profile->execute([$email, $user_id]);

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
            'title' => 'error',
            'text' => 'Please Enter Old Password!',
        ];
    } elseif ($old_pass != $prev_pass) {
        $response = [
            'icon' => 'error',
            'title' => 'error',
            'text' => 'Old Password Not Matched!',
        ];
    } elseif ($new_pass != $cpass) {
        $response = [
            'icon' => 'error',
            'title' => 'error',
            'text' => 'Username Already Exist!',
        ];
        $message[] = 'Username Already Exist!';
    } else {
        if ($new_pass != $empty_pass) {
            $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_admin_pass->execute([$cpass, $user_id]);
            $response = [
                'icon' => 'success',
                'title' => 'success',
                'text' => 'Password Update Successfully!',
            ];
        } else {
            $response = [
                'icon' => 'error',
                'title' => 'error',
                'text' => 'Please Enter A New Password!',
            ];
        }

        $responseJSON = json_encode($response);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
         margin:-9.7rem auto;
         z-index: -1;
         position: absolute;
      }
   </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3>Reset Password</h3>
                        </div>
                        <form action="" method="post">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="prev_pass" value="<?= $fetch_profile["password"]; ?>" placeholder="Name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email"  class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Old Password</label>
                                <input type="password" name="old_pass" placeholder="Enter Old Password" maxlength="20"
                                    class="form-control password" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">New Password</label>
                                <input type="password" name="new_pass" placeholder="Enter New Password" maxlength="20"
                                    class="form-control password" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Retype-password</label>
                                <input type="password" name="cpass" placeholder="Retype-password" maxlength="20"
                                    class="form-control password" required>
                            </div>
                            <div class="icheck-primary mt-3">
                                <input type="checkbox" class="show toggle-password form-check-input" id="toggle-password" style="cursor:pointer">
                                <label class="form-check-label" for="toggle-password">Show password</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                            </div>
                            <div class="text-center mt-3">
                            <h6><a class="text-decoration-none" href="user_login.php">Back to login</a></h6>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </section>

    <script src="js/password.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
    <script src="js/admin_script.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/input.js"></script>
    <script src="js/app.min.js"></script>
    <script src="js/admin_script.js"></script>
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
    <svg class="svg" id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 190" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(62, 243, 76.819, 1)" offset="0%"></stop><stop stop-color="rgba(11, 255, 245.907, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,152L10,148.8C20,146,40,139,60,114C80,89,100,44,120,41.2C140,38,160,76,180,82.3C200,89,220,63,240,53.8C260,44,280,51,300,50.7C320,51,340,44,360,47.5C380,51,400,63,420,79.2C440,95,460,114,480,114C500,114,520,95,540,72.8C560,51,580,25,600,22.2C620,19,640,38,660,47.5C680,57,700,57,720,76C740,95,760,133,780,142.5C800,152,820,133,840,126.7C860,120,880,127,900,123.5C920,120,940,108,960,114C980,120,1000,146,1020,142.5C1040,139,1060,108,1080,79.2C1100,51,1120,25,1140,25.3C1160,25,1180,51,1200,66.5C1220,82,1240,89,1260,95C1280,101,1300,108,1320,101.3C1340,95,1360,76,1380,63.3C1400,51,1420,44,1430,41.2L1440,38L1440,190L1430,190C1420,190,1400,190,1380,190C1360,190,1340,190,1320,190C1300,190,1280,190,1260,190C1240,190,1220,190,1200,190C1180,190,1160,190,1140,190C1120,190,1100,190,1080,190C1060,190,1040,190,1020,190C1000,190,980,190,960,190C940,190,920,190,900,190C880,190,860,190,840,190C820,190,800,190,780,190C760,190,740,190,720,190C700,190,680,190,660,190C640,190,620,190,600,190C580,190,560,190,540,190C520,190,500,190,480,190C460,190,440,190,420,190C400,190,380,190,360,190C340,190,320,190,300,190C280,190,260,190,240,190C220,190,200,190,180,190C160,190,140,190,120,190C100,190,80,190,60,190C40,190,20,190,10,190L0,190Z"></path></svg>
</body>

</html>