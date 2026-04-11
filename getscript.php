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

	$allowed_os = ['mac', 'linux', 'windows'];
	$os = in_array($_GET['os'] ?? '', $allowed_os, true) ? $_GET['os'] : 'mac';
	$templates = [
		'mac'     => ['file' => 'voupr-update.sh.template',       'name' => 'voupr-update.sh'],
		'linux'   => ['file' => 'voupr-update-linux.sh.template', 'name' => 'voupr-update-linux.sh'],
		'windows' => ['file' => 'voupr-update.ps1.template',      'name' => 'voupr-update.ps1'],
	];
	$template_file = $templates[$os]['file'];
	$download_name = $templates[$os]['name'];

	$base_url = 'https://' . $_SERVER['SERVER_NAME'];
	$template = file_get_contents(__DIR__ . '/' . $template_file);
	$script   = str_replace(['{{TOKEN}}', '{{BASE_URL}}'], [$token, $base_url], $template);

	header('Content-Type: text/plain; charset=utf-8');
	header('Content-Disposition: attachment; filename="' . $download_name . '"');
	header('X-Content-Type-Options: nosniff');
	echo $script;
	exit();
?>
