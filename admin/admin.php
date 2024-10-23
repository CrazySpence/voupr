<? require('../component.php'); ?>
<? require('../database.php'); ?>

<? $post_login = 'admin/'; ?>
<? require('../loggedin.php'); ?>

<? if (!$admin) { $admin = TRUE;
	/////////////////////////////////////////////////////////
	
	$query = 'SELECT admin FROM users WHERE username="'.$user_sname.'"';
	$result = mysqli_query($db,$query);
	$row = mysqli_fetch_array($result);
	if ($row['admin'] != TRUE) { $redirect_url = '../404error.php'; require('../redirect.php'); }
} ?>
