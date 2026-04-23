<? require('../component.php'); ?>
<? require('../database.php'); ?>

<? $post_login = 'admin/'; ?>
<? require('../loggedin.php'); ?>

<? if (!$admin) { $admin = TRUE;
	/////////////////////////////////////////////////////////
	
	$result = db_run('SELECT admin FROM users WHERE username=?', 's', $user_sname);
	$row = mysqli_fetch_array($result);
	if ($row['admin'] != TRUE) { $redirect_url = '../404error.php'; require('../redirect.php'); }
} ?>
