<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? $post_login = 'donewplugin.php'; ?>
<? require('loggedin.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$pluginname = mysqli_real_escape_string($db,strtolower($_POST['pluginname']));
	$dispname = mysqli_real_escape_string($db,$_POST['displayname']);
	$description = mysqli_real_escape_string($db,$_POST['description']);
	$file = $_FILES['upload'];
	$version = mysqli_real_escape_string($db,$_POST['version']);
	
	// Check plugin name
	if (strlen($pluginname) == 0) { $badpluginname = TRUE; }
	else
	{
		$query = 'SELECT * FROM plugins WHERE name="'.$pluginname.'"';
		$result = mysqli_query($db,$query);
		if (mysqli_fetch_array($result)) { $badpluginname = TRUE; }
	}
	if (strpos($pluginname, " ")) { $pluginnamehasspace = TRUE; }
	
	// Check display name
	if (strlen($dispname) == 0) { $baddispname = TRUE; }
	else
	{
		$query = 'SELECT name FROM plugins WHERE LOWER(longname)=LOWER("'.$dispname.'") LIMIT 1';
		$result = mysqli_query($db,$query);
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
		// Set variables
		$name = $pluginname;
		$longname = $dispname;
		$description = $description;
		$version = $version;
		$file = $file;
		// Upload file
		$path = 'downloads/'.$name.'-'.$version.'.zip';
		if (!move_uploaded_file($file['tmp_name'], $path))
			{ die('Error uploading file!'); }
		chmod($path, 0644);
		// Create plugin
		// Add plugin
		$query = 'INSERT INTO plugins (name, longname, description, authors) VALUES ("'.$name.'", "'.$longname.'", "'.$description.'", "'.getuserdispname($user_sname).'")';
		mysqli_query($db,$query);
		// Add manager
		$query = 'INSERT INTO managers (username, pluginname) VALUES ("'.$user_sname.'", "'.$name.'")';
		mysqli_query($db,$query);
		// Add version
		$query = 'INSERT INTO versions (plugin, versionstring, timestamp, description) VALUES ("'.$name.'", "'.$version.'", NOW(), "Initial upload.")';
		mysqli_query($db,$query);
		// Add to user's plugins
		$id = getversionid($name, $version);
		$query = 'INSERT INTO installed (user, plugin, version) VALUES ("'.$user_sname.'", "'.$name.'", "'.$id.'")';
		mysqli_query($db,$query);
		
		// Redirect to plugin page
		$redirect_url = 'plugin.php?name='.$name;
		require('redirect.php');
	}
?>
