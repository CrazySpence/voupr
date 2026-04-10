<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	csrf_verify();

	// Get form variables
	$plugin = $_POST['plugin'];
	$file = $_FILES['upload'];
	$version = $_POST['version'];
	$description = $_POST['description'];
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Plugin does not exist'); }
	
	// Check user
	$post_login = 'plugin.php?plugin='.$plugin;
	require('loggedin.php');
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	// Check file
	if ($file['error'] > 0) { $badfile = TRUE; }
	else if ($file['size'] > 10000000) { $bigfile = TRUE; }
	else if (substr($file['name'], -4) != ".zip") { $badfiletype = TRUE; }
	
	// Check version
	if (strlen($version) == 0) { $badversion = TRUE; }
	else
	{
		$result = db_run('SELECT plugin FROM versions WHERE plugin=? AND LOWER(versionstring)=LOWER(?) LIMIT 1', 'ss', $plugin, $version);
		if (mysqli_fetch_array($result)) { $dupversion = TRUE; }
	}
?>

<?
	if ($badfile or $bigfile or $badfiletype or $badversion or $dupversion)
	{
		// Save form data
		require('session.php');
		$_SESSION['newversion_version'] = $version;
		$_SESSION['newversion_description'] = $description;
		// Return to page with errors
		$url = 'newversion.php?plugin='.$plugin.'&';
		if ($badfile){ $url = $url.'badfile=TRUE&'; }
		if ($bigfile) { $url = $url.'bigfile=TRUE&'; }
		if ($badfiletype) { $url = $url.'badfiletype=TRUE&'; }
		if ($badversion) { $url = $url.'badversion=TRUE&'; }
		if ($dupversion) { $url = $url.'dupversion=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		// Upload file
		$path = 'downloads/'.$plugin.'-'.$version.'.zip';
		if (!move_uploaded_file($file['tmp_name'], $path))
			{ die('Error uploading file!'); }
		chmod($path, 0644);
		// Add version
		db_run('INSERT INTO versions (plugin, versionstring, timestamp, description) VALUES (?, ?, NOW(), ?)', 'sss', $plugin, $version, $description);

		// Go to version page
		$id = getversionid($plugin, $version);
		$redirect_url = 'version.php?id='.$id.'';
		require('redirect.php');
	}
?>
