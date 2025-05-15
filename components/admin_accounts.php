<?php
require_once '../includes/session_manager.php';
ensure_session_started();
$admin_id = check_admin_login();

require_once '../components/connect.php';

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_admins->execute([$delete_id]);
    header('location:admin_accounts1.php');
    exit; // Add an exit statement after the header to stop further execution
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$name]);

    if ($select_admin->rowCount() > 0) {
        $response = [
            'icon' => 'error',
            'title' => 'error',
            'text' => 'Username Already Exist!',
        ];
    } else {
        if ($pass != $cpass) {
            $response = [
                'icon' => 'error',
                'title' => 'error',
                'text' => 'Password not matched!',
            ];
        } else {
            $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
            $insert_admin->execute([$name, $cpass]);
            $response = [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'New Admin Registered!',
            ];
        }
    }

    $responseJSON = json_encode($response);
    header('location:admin_accounts1.php'); // Redirect to prevent form resubmission
    exit; // Add an exit statement after the header to stop further execution
}

if (isset($_POST['create_subadmin'])) {
    $subadmin_username = $_POST['subadmin_username'];
    $subadmin_username = filter_var($subadmin_username, FILTER_SANITIZE_STRING);
    $subadmin_password = sha1($_POST['subadmin_password']);
    $subadmin_password = filter_var($subadmin_password, FILTER_SANITIZE_STRING);
    $subadmin_cpassword = sha1($_POST['subadmin_cpassword']);
    $subadmin_cpassword = filter_var($subadmin_cpassword, FILTER_SANITIZE_STRING);

    $select_subadmin = $conn->prepare("SELECT * FROM `subadmin` WHERE name = ?");
    $select_subadmin->execute([$subadmin_username]);

    if ($select_subadmin->rowCount() > 0) {
        $response = [
            'icon' => 'error',
            'title' => 'Error',
            'text' => 'Username Already Exists!',
        ];
    } else {
        if ($subadmin_password != $subadmin_cpassword) {
            $response = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Passwords do not match!',
            ];
        } else {
            $insert_subadmin = $conn->prepare("INSERT INTO `subadmin` (name, password) VALUES (?, ?)");
            $insert_subadmin->execute([$subadmin_username, $subadmin_password]);
            $response = [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'New Subadmin Created!',
            ];
        }
    }

    $responseJSON = json_encode($response);
    header('location:admin_accounts1.php'); // Redirect to prevent form resubmission
    exit; // Add an exit statement after the header to stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/index.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>


<body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed antialiased">
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Accounts</h1>
                </div>
            </div>
        </div>
    </section>
<br><br>
    <section class="content">
       
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow rounded-lg">
                    <h4>Add SuperAdmin</h4>
                        <div class="card-body">
                            <form action="" method="post" autocomplete="off">
                                <!-- Username input -->
                                <div class="mb-2">
                                    <label class="h6" for="username">Username</label>
                                    <input type="text" class="form-control" name="name" id="username">
                                </div>
                                <!-- Password input -->
                                <div class="mb-2">
                                    <label class="h6" for="password">Password</label>
                                    <input type="password" class="form-control" name="pass" id="password">
                                </div>
                                <!-- Re-enter Password input -->
                                <div class="mb-2">
                                    <label class="h6" for="password">Re-enter Password</label>
                                    <input type="password" class="form-control" name="cpass" id="password">
                                </div>
                                <!-- Login button -->
                                <div class="text-center mt-4 mb-2 h6">
                                    <button type="submit" name="submit" class="btn btn-block btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow rounded-lg">
                    <h4>Add SubAdmin</h4>
                        <div class="card-body">
                            <form action="" method="post" autocomplete="off">
                                <!-- Subadmin username input -->
                                <div class="mb-2">
                                    <label class="h6" for="subadmin-username">Subadmin Username</label>
                                    <input type="text" class="form-control" name="subadmin_username" id="subadmin-username">
                                </div>
                                <!-- Subadmin password input -->
                                <div class="mb-2">
                                    <label class="h6" for="subadmin-password">Subadmin Password</label>
                                    <input type="password" class="form-control" name="subadmin_password" id="subadmin-password">
                                </div>
                                <!-- Re-enter subadmin password input -->
                                <div class="mb-2">
                                    <label class="h6" for="subadmin-password">Re-enter Subadmin Password</label>
                                    <input type="password" class="form-control" name="subadmin_cpassword" id="subadmin-password">
                                </div>
                                <!-- Create subadmin button -->
                                <div class="text-center mt-4 mb-2 h6">
                                    <button type="submit" name="create_subadmin" class="btn btn-block btn-primary">Create Subadmin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    $select_accounts = $conn->prepare("SELECT * FROM `admins`");
                    $select_accounts->execute();
                    if ($select_accounts->rowCount() > 0) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped" style="width: 100%; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th style="width: 33%;">SuperAdmin ID</th>
                                    <th style="width: 33%;">Name</th>
                                    <th style="width: 33%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $fetch_accounts['id']; ?></td>
                                    <td><?= $fetch_accounts['name']; ?></td>
                                    <td>
                                        <a href="admin_accounts1.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this account?')" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    } else {
                       echo '<p class="text-center">No Accounts Available</p>';
                    }
                    ?>
                </div>
                
                <div class="col-md-6">
                    <?php
                    $select_accounts = $conn->prepare("SELECT * FROM `subadmin`");
                    $select_accounts->execute();
                    if ($select_accounts->rowCount() > 0) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped" style="width: 100%; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th style="width: 33%;">Subadmin ID</th>
                                    <th style="width: 33%;">Name</th>
                                    <th style="width: 33%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $fetch_accounts['id']; ?></td>
                                    <td><?= $fetch_accounts['name']; ?></td>
                                    <td>
                                        <a href="admin_accounts1.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this subadmin account?')" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    } else {
                        echo '<p class="text-center">No Subadmin Accounts Available</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
    <script src="../js/admin_script.js"></script>
    <script src="../js/carousel.js"></script>
    <script src="../js/input.js"></script>
    <script src="../js/image.js"></script>
    <script src="../js/app.min.js"></script>
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
</body>
</html>