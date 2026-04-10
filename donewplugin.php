<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? $post_login = 'donewplugin.php'; ?>
<? require('loggedin.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$pluginname = strtolower($_POST['pluginname']);
	$dispname = $_POST['displayname'];
	$description = $_POST['description'];
	$file = $_FILES['upload'];
	$version = $_POST['version'];
	
	// Check plugin name
	if (strlen($pluginname) == 0) { $badpluginname = TRUE; }
	else
	{
		$result = db_run('SELECT * FROM plugins WHERE name=?', 's', $pluginname);
		if (mysqli_fetch_array($result)) { $badpluginname = TRUE; }
	}
	if (strpos($pluginname, " ")) { $pluginnamehasspace = TRUE; }
	
	// Check display name
	if (strlen($dispname) == 0) { $baddispname = TRUE; }
	else
	{
		$result = db_run('SELECT name FROM plugins WHERE LOWER(longname)=LOWER(?) LIMIT 1', 's', $dispname);
		if (mysqli_fetch_array($result)) { $baddispname = TRUE; }
	}
	
	// Check file
	if ($file['error'] > 0) { $badfile = TRUE; }
	else if ($file['size'] > 10000000) { $bigfile = TRUE; }
	else if (substr($file['name'], -4) != ".zip") { $badfiletype = TRUE; }
	
	// Check version
	if (strlen($version) == 0) { $badversion = TRUE; }


	
	// Do stuff
	if ($badpluginname or $baddispname or $badfile or $bigfile or $badfiletype or $badversion or $pluginnamehasspace)
	{
		// Save form data
		require('session.php');
		$_SESSION['newplugin_name'] = $pluginname;
		$_SESSION['newplugin_dispname'] = $dispname;
		$_SESSION['newplugin_description'] = $description;
		$_SESSION['newplugin_version'] = $version;
		// Return to page with errors
		$url = 'newplugin.php?';
		if ($badpluginname) { $url = $url.'badpluginname=TRUE&'; }
		if ($pluginnamehasspace) { $url = $url.'pluginnamehasspace=TRUE&'; }
		if ($baddispname) { $url = $url.'baddispname=TRUE&'; }
		if ($badfile){ $url = $url.'badfile=TRUE&'; }
		if ($bigfile) { $url = $url.'bigfile=TRUE&'; }
		if ($badfiletype) { $url = $url.'badfiletype=TRUE&'; }
		if ($badversion) { $url = $url.'badversion=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		include('redirect.php');
	} else {
		$name = $pluginname;
		// Upload file
		$path = 'downloads/'.$name.'-'.$version.'.zip';
		if (!move_uploaded_file($file['tmp_name'], $path))
			{ die('Error uploading file!'); }
		chmod($path, 0644);
		// Create plugin
		// Add plugin
		db_run('INSERT INTO plugins (name, longname, description, authors) VALUES (?, ?, ?, ?)', 'ssss', $name, $dispname, $description, getuserdispname($user_sname));
		// Add manager
		db_run('INSERT INTO managers (username, pluginname) VALUES (?, ?)', 'ss', $user_sname, $name);
		// Add version
		db_run('INSERT INTO versions (plugin, versionstring, timestamp, description) VALUES (?, ?, NOW(), "Initial upload.")', 'ss', $name, $version);
		// Add to user's plugins
		$id = getversionid($name, $version);
		db_run('INSERT INTO installed (user, plugin, version) VALUES (?, ?, ?)', 'ssi', $user_sname, $name, $id);
		
		// Redirect to plugin page
		$redirect_url = 'plugin.php?name='.$name;
		require('redirect.php');
	}
?>
