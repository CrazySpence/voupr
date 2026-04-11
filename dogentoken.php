<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>

<?
	csrf_verify();

	$post_login = 'settings.php';
	require('loggedin.php');

	$token = bin2hex(random_bytes(32));
	db_run('UPDATE users SET api_token=? WHERE username=?', 'ss', $token, $user_sname);
?>

<? $page_title = 'API Token - VOUPR'; ?>
<? include('header.php'); ?>

	<h3>API Token Generated</h3>
	<p>Your new API token is shown below. <strong>Copy it now &mdash; it will not be shown again.</strong></p>
	<div class="infobox">
		<code><?=htmlspecialchars($token)?></code>
	</div>
	<p><a href="settings.php">Back to Settings</a></p>

<? include('footer.php'); ?>
