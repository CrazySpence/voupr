<?
	// Header data
	$page_title = TRUE;
	require('database.php');
	require('fullurl.php');
	require('userauth.php');

	// Get form variables
	$username = strtolower($_POST['username']);
	$password = $_POST['password'];
	$remember = $_POST['remember'];
	
	// Check credentials
	$badlogin = check_login($username, $password, $remember);
	
	if ($badlogin) {
		// Redirect on failure
		$redirect_url = 'login.php?badlogin=TRUE';
		require('redirect.php');
	} else {
		// Redirect on success
		if ($_SESSION['post_login']) {
			$redirect_url = $_SESSION['post_login'];
			require('redirect.php');
		} else { ?>
		
			<? $page_title = $longname.'Login Succesfull - VOUPR'; ?>
			<? include('header.php'); ?>
		
				<h3>Logged In</h3>
				You are now logged in.
		
			<? include('footer.php'); ?>
			
	<? } ?>
<? } ?>
