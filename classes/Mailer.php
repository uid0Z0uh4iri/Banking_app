<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions





function sendAccountDetails($email, $name, $password) {

$mail = new PHPMailer(true);

    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '323f68d97c5025';                     //SMTP username
    $mail->Password   = 'f381bf8f68279d';                               //SMTP password
    $mail->SMTPSecure = "SSL";            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->Subject = 'Here is the subject';
    $mail->setFrom('itsmezouhairi@gmail.com', 'Mailer');
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->addAddress($email, $name);
    $mail->Body    = 'Welcome to Baka2Ka, this is your password you should update it and update your informations in the app. Password : <b>'. $password .' </b>';
    $mail->send();
    return true;
}