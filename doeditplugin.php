<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>
<? require('session.php'); ?>

<?
	csrf_verify();

	// Get form variables
	$plugin = strtolower($_POST['plugin']);
	$dispname = $_POST['displayname'];
	$description = $_POST['description'];
	
	// Require login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check plugin name
	if (strlen($plugin) == 0) { $badpluginname = TRUE; }
	else
	{
		$result = db_run('SELECT name FROM plugins WHERE name=?', 's', $plugin);
		if (!mysqli_fetch_array($result)) { require('404redirect.php'); }
	}
	
	// Check authorization
	if (!ismanager($plugin)) { require('404redirect.php'); }
	
	// Check display name
	if (strlen($dispname) == 0) { $baddispname = TRUE; }
	else
	{
		$result = db_run('SELECT name FROM plugins WHERE LOWER(longname)=LOWER(?) AND name!=? LIMIT 1', 'ss', $dispname, $plugin);
		if (mysqli_fetch_array($result)) { $baddispname = TRUE; }
	}
?>

<?
	if ($badpluginname or $baddispname)
	{
		// Save form data
		require('session.php');
		$_SESSION['editplugin_dispname'] = $dispname;
		$_SESSION['editplugin_description'] = $description;
		// Return to page with errors
		$url = 'editplugin.php?';
		if ($baddispname) { $url = $url.'baddispname=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		db_run('UPDATE plugins SET longname=?, description=? WHERE name=?', 'sss', $dispname, $description, $plugin);
		
		// Redirect
		$redirect_url = 'editplugin.php?plugin='.$plugin;
		require('redirect.php');
	}
?>
