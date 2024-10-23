<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('fullurl.php'); ?>
<?
        //Switched to PHPMailer for e-mail as I no longer run local mail
        //composer require PHPMailer\PHPMailer
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require 'vendor/autoload.php';
	// Get form variables
	$username = mysqli_real_escape_string($db,strtolower($_POST['username']));
	$email = mysqli_real_escape_string($db,strtolower($_POST['email']));
	$pass1 = $_POST['password'];
	$pass2 = $_POST['passcheck'];
	
	// Check username
	$query = 'SELECT * FROM users WHERE username="'.$username.'"';
	$result = mysqli_query($db,$query);
	if (mysqli_fetch_array($result)) { $badusername = TRUE; }
	
	// Check password
	if (strlen($pass1) < 6) { $badpassword = TRUE; }
	if ($pass1 != $pass2) { $diffpasswords = TRUE; }
	
	// Check email
	$query = 'SELECT * FROM users WHERE email="'.$email.'"';
	$result = mysqli_query($db,$query);
	if (mysqli_fetch_array($result)) { $dupemail = TRUE; }
	else if (!($badusername or $badpassword or $diffpasswords))
	{
		$to = $email;
		$subject = 'VOUPR Account Confirmation';
		$message = 'Please visit the following link to confirm your account: '.$full_url.'confirmuser.php?user='.$username;
		$mail = new PHPMailer(true);
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
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
            // Send the message
	    //             $mail->send();
		//		$bademail = !mail($to, $subject, $message);
	}
?>

<? if ($badusername or $badpassword or $diffpasswords or $bademail or $dupemail) {
	$url = 'register.php?';
	if ($badusername) { $url = $url.'badusername=TRUE&'; }
	if ($badpassword) { $url = $url.'badpassword=TRUE&'; }
	if ($diffpasswords) { $url = $url.'diffpasswords=TRUE&'; }
	if ($bademail) { $url = $url.'bademail=TRUE&'; }
	if ($dupemail) { $url = $url.'dupemail=TRUE&'; }
	$redirect_url = substr($url, 0, -1);
	require('redirect.php');
} else { ?>

	<?
		// Create account
		$username = $username;
		$password = $pass1;
		$email = $email;
		$longname = $username;
		$query = 'INSERT INTO users (username, password, email, longname, created, confirmed) VALUES ("'.$username.'", "'.md5($password).'", "'.$email.'", "'.$longname.'", CURDATE(), FALSE)';
		mysqli_query($db,$query);
	?>
	
	<? $page_title = $longname.'Registration Succesfull - VOUPR'; ?>
	<? include('header.php'); ?>
		
		<h3>Account Created</h3>
		You should receieve a confirmation email shortly.
		
	<? include('footer.php'); ?>

<? } ?>
