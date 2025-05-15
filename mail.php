<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function sendemail_verify($name, $email, $verify_token){

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        
        // TODO: Replace with your Gmail and App Password
        $mail->Username   = 'ritzmonsmanzo@gmail.com';                 //Your Gmail address
        $mail->Password   = 'bxdk sosc nusz yofq';          //Your Gmail App Password (NOT your regular Gmail password)
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to
        
        //Set timeout
        $mail->Timeout    = 5;
        $mail->SMTPDebug  = 0;                                     //Disable debug output

        //Recipients
        $mail->setFrom('your-email@gmail.com', 'Agrifarm Team');   //Set this same as your Gmail
        $mail->addAddress($email, $name);                          //Add recipient

        //Content
        $mail->isHTML(true);
        
        $bodyContent = "<!DOCTYPE html>";
        $bodyContent .= "<html>";
        $bodyContent .= "<head>";
        $bodyContent .= "<meta charset='utf-8'>";
        $bodyContent .= "</head>";
        $bodyContent .= "<body style='font-family: Arial, sans-serif;'>";
        $bodyContent .= "<div style='max-width: 600px; margin: 0 auto; padding: 20px;'>";
        $bodyContent .= "<h2 style='color: #3B82F6;'>Welcome to Agrifarm!</h2>";
        $bodyContent .= "<p>Dear $name,</p>";
        $bodyContent .= "<p>Thank you for registering with Agrifarm. Please verify your email address to complete your registration.</p>";
        $bodyContent .= "<p style='margin: 25px 0;'>";
        $bodyContent .= "<a href='http://localhost/Agrifarm-eConnect-v2/verify.php?token=$verify_token' 
                        style='background-color: #3B82F6; color: white; padding: 12px 30px; text-decoration: none; 
                        border-radius: 5px; display: inline-block;'>Verify Your Email</a>";
        $bodyContent .= "</p>";
        $bodyContent .= "<p><strong>Note:</strong> You cannot login until your email is verified.</p>";
        $bodyContent .= "<hr style='border: 1px solid #eee; margin: 20px 0;'>";
        $bodyContent .= "<p style='color: #666; font-size: 14px;'>Best regards,<br>The Agrifarm Team</p>";
        $bodyContent .= "</div>";
        $bodyContent .= "</body>";
        $bodyContent .= "</html>";
        
        $mail->Subject = 'Verify Your Agrifarm Account';
        $mail->Body    = $bodyContent;
        $mail->AltBody = 'Please verify your Agrifarm account by clicking this link: http://localhost/Agrifarm-eConnect-v2/verify.php?token='.$verify_token;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: {$mail->ErrorInfo}");
        return false;
    }
}

/*
HOW TO SET UP GMAIL APP PASSWORD:

1. Go to your Google Account settings (https://myaccount.google.com/)
2. Enable 2-Step Verification if not already enabled
3. Go to Security → App passwords (https://myaccount.google.com/apppasswords)
4. Select "Mail" and "Windows Computer" from the dropdowns
5. Click "Generate"
6. Copy the 16-digit password
7. Replace 'your-16-digit-app-password' in this file with that password
8. Replace 'your-email@gmail.com' with your Gmail address

Note: Keep your app password secure and never share it!
*/
?>