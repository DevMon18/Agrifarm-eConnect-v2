<?php 
session_start();

require_once 'conn.php';

if(isset($_POST['login_btn']))
{
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, sha1($_POST['password']));

        $login_query ="SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1 ";
        $login_query_run = mysqli_query($con, $login_query);

        if(mysqli_num_rows($login_query_run) > 0)
        {
            $row = mysqli_fetch_array($login_query_run);

            if($row['verify_status'] == "1")
            {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['auth_user'] = [
                    'username' => $row['name'],
                    'number' => $row['number'],
                    'email' => $row['email'],
                ];
                $_SESSION['status'] = "You are Login Successfully!";
                header("Location: index.php");
                exit(0);
            }
            else {
                $_SESSION['status'] = "Please Verify address to Login!";
                header("Location: user_login.php");
                exit(0);
            }
            
        }
        else {
            $_SESSION['status'] = "Invalid Email or Password!";
            header("Location: user_login.php");
            exit(0);
        }
    }
    else{
        $_SESSION['status'] = "All field Required!";
        header("Location: user_login.php");
        exit(0);
    }
}
?>