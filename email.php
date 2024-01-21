<?php 
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
include 'functions.php';
if(isset($_GET['id'])){
    $bin = '';
    $file = get_file($_GET['id']);
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.org';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'admin@example.org';                     //SMTP username
    $mail->Password   = '87654321';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('admin@example.org', 'File sharing service');
    //Attachments
    $mail->addAddress($_GET['email']);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Link to a file';
    $mail->Body    = str_replace('%URL%', 'https://'.$_SERVER['SERVER_NAME'].'/dl/dl.php?id='.urlencode($file['id']), str_replace('%FN%', $file['name'], file_get_contents('email.html')));
    $mail->send();
}
?>
