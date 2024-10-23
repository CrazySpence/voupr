<?
	// Header data
	$page_title = 'Sign Out - VOUPR';
	require('userauth.php');
	user_logout();
	delete_cookies();
?>

<? include('header.php'); ?>

<h3>Signed Out</h3>

Your account has been signed out.

<? include('footer.php'); ?>
