<? require('../headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('../database.php'); ?>
<? require('../utilities.php'); ?>
<? require('../session.php'); ?>
<? require('admin.php'); ?>

<?
	// Get form variables
	$user = safe($_POST['user']);
	$password = $_POST['password'];
	
	// Check password
	if (strlen($password) < 6) { $badpassword = TRUE; }
	
	// Check user name
	if (!userexists($user)) { $baduser = TRUE; }
	
	// Do stuff
	if ($baduser or $badpassword)
	{
		// Return to page with errors
		$url = 'resetpassword.php?user='.$user.'&';
		if ($baduser) { $url = $url.'baduser=TRUE&'; }
		if ($badpassword) { $url = $url.'badpassword=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('../redirect.php');
	} else {
		$query = 'UPDATE users SET password="'.md5($password).'" WHERE username="'.$user.'"';
		mysqli_query($db,$query);
		
		// Return to page
		$redirect_url = 'resetpassword.php?success=TRUE';
		require('../redirect.php');
	}
?>
