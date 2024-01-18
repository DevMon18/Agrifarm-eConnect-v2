<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function sendemail_verify($name, $email, $verify_token){

    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ritzmond.manzo@evsu.edu.ph';                   //SMTP username
    $mail->Password   = '091897Ritzmondmanzo@';                  //SMTP password
    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('ritzmond.manzo@evsu.edu.ph', $name);
    $mail->addAddress($email);                                  //Name is optional

    //Content
    $mail->isHTML(true);
    
    $bodyContent = "<!DOCTYPE html>";
    $bodyContent .= "<html>";
    $bodyContent .= "<head>";
    $bodyContent .= "<meta charset='utf-8'>";
    $bodyContent .= "</head>";
    $bodyContent .= "<body>";
    $bodyContent .= "<br>";
    $bodyContent .= "<p>Dear user, $name</p>";
    $bodyContent .= "<p>Click on the following link to verify your account.</p>";
    $bodyContent .= "<p>-------------------------------------------------------------</p>";
    $bodyContent .= "<p><a href='http://localhost/Agrifarm-econnect/verify.php?token=$verify_token'>Click here to Verify</a></p>";
    $bodyContent.='<p>You cannot Login unless you are verified!.</p>';
    $bodyContent .='<p>Thanks,</p>';
    $bodyContent .='<p>Agrifarm Team</p>';
    $bodyContent .= "</body>";
    $bodyContent .= "</html>";
    $mail->Subject = 'Agrifarm Team';
    $mail->Body    = $bodyContent;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
}

?>