<?
//Switched to PHPMailer for e-mail as I no longer run local mail
//composer require PHPMailer\PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$email = 'phil@philtopia.com';
$full_url = "http://test.com/";
$username = "testman";
$to = $email;
                $subject = 'VOUPR Account Confirmation';
                $message = 'Please visit the following link to confirm your account: '.$full_url.'confirmuser.php?user='.$username;
		$mail = new PHPMailer();
	//	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.mail.me.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'commodorespence@icloud.com';
                $mail->Password = 'xoav-gxnz-imhw-bvzf';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('wiki-auto@vo-wiki.com','VOUPR Registration');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $message;
                $mail->AltBody = $message;
		$mail->send();
?>
