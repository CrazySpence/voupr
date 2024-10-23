<? require('component.php'); ?>
<? require('session.php'); ?>
<? require('userauth.php'); ?>

<? if (!$loggedin) { $loggedin = TRUE;
	/////////////////////////////////////////////////////////
	
	$_SESSION['post_login'] = $post_login;
	if (!$user_loggedin)
	{
		$redirect_url = $SERVER.'login.php';
		require('redirect.php');
		exit();
	}
} ?>
