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

	$os = ($_GET['os'] === 'linux') ? 'linux' : 'mac';
	$template_file = ($os === 'linux') ? 'voupr-update-linux.sh.template' : 'voupr-update.sh.template';
	$download_name = ($os === 'linux') ? 'voupr-update-linux.sh' : 'voupr-update.sh';

	$base_url = 'https://' . $_SERVER['SERVER_NAME'];
	$template = file_get_contents(__DIR__ . '/' . $template_file);
	$script   = str_replace(['{{TOKEN}}', '{{BASE_URL}}'], [$token, $base_url], $template);

	header('Content-Type: text/plain; charset=utf-8');
	header('Content-Disposition: attachment; filename="' . $download_name . '"');
	header('X-Content-Type-Options: nosniff');
	echo $script;
	exit();
?>
