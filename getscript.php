<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>

<?
	$post_login = 'getscript.php';
	require('loggedin.php');

	$result = db_run('SELECT api_token FROM users WHERE username=?', 's', $user_sname);
	$row = mysqli_fetch_array($result);
	$token = $row['api_token'] ?? '';

	if (empty($token)) {
		$redirect_url = 'settings.php';
		include('redirect.php');
		exit();
	}

	$base_url = 'https://' . $_SERVER['SERVER_NAME'];
	$template = file_get_contents(__DIR__ . '/voupr-update.sh.template');
	$script   = str_replace(['{{TOKEN}}', '{{BASE_URL}}'], [$token, $base_url], $template);

	header('Content-Type: text/plain; charset=utf-8');
	header('Content-Disposition: attachment; filename="voupr-update.sh"');
	header('X-Content-Type-Options: nosniff');
	echo $script;
	exit();
?>
