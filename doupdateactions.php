<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	csrf_verify();

	$post_login = 'userplugins.php';
	require('loggedin.php');

	$allowed = ['ask', 'install', 'download', 'skip'];

	if (is_array($_POST['action'])) {
		foreach ($_POST['action'] as $plugin => $action) {
			if (!in_array($action, $allowed, true)) { continue; }
			// user=? ensures users can only update their own rows
			db_run('UPDATE installed SET update_action=? WHERE user=? AND plugin=?',
				'sss', $action, $user_sname, $plugin);
		}
	}

	$redirect_url = 'userplugins.php';
	require('redirect.php');
?>
