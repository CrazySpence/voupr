<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('userauth.php'); ?>

<?
	// Check login
	$post_login = 'settings.php';
	require('loggedin.php');
	
	// Get form data
	$username = $user_sname;
	$oldpass = $_POST['oldpassword'];
	$newpass = $_POST['newpassword'];
	$newpass2 = $_POST['confirmpassword'];
	
	// Check old password
	if (!password_match($username, md5($oldpass))) { $badoldpass = TRUE; }
	
	// Check password match
	if ($newpass != $newpass2) { $passmismatch = TRUE; }
	
	// Check password length
	if (strlen($newpass) < 6) { $shortpass = TRUE; }
	
	
	
	// Do stuff
	if ($badoldpass or $passmismatch or $shortpass) {
		// Return to page with errors
		$url = 'settings.php?';
		if ($badoldpass) { $url = $url.'badoldpass=TRUE&'; }
		if ($passmismatch) { $url = $url.'passmismatch=TRUE&'; }
		if ($shortpass){ $url = $url.'shortpass=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		include('redirect.php');
	} else {
		$query = 'UPDATE users SET password="'.md5($newpass).'" WHERE username="'.$user_sname.'"';
		mysqli_query($db,$query);
	?>
	
		<? $page_title = 'Password Updated - VOUPR'; ?>
		<? include('header.php'); ?>
			
			<h3>Password changed</h3>
			Your password has been changed.
			
		<? include('footer.php'); ?>
		
	<? }
?>
