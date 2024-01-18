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
         'title' => 'error',
         'text' => 'Incorrect username or password!',
      ];
   }

   $responseJSON = json_encode($response);
}

?>

<?php require "../components/header.php"; ?>

<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
   }
}
?>

<?php require "../components/admin_auth.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/admin_script.js"></script>
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