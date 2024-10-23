<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$plugin = mysqli_real_escape_string($db,$_POST['plugin']);
	$file = $_FILES['upload'];
	$version = mysqli_real_escape_string($db,$_POST['version']);
	$description = mysqli_real_escape_string($db,$_POST['description']);
	
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
		$query = 'SELECT plugin FROM versions WHERE plugin="'.$plugin.'" AND LOWER(versionstring)=LOWER("'.$version.'") LIMIT 1';
		$result = mysqli_query($db,$query);
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
		// Set variables
		$plugin = $plugin;
		$file = $file;
		$version = $version;
		$description = $description;
		// Upload file
		$path = 'downloads/'.$plugin.'-'.$version.'.zip';
		if (!move_uploaded_file($file['tmp_name'], $path))
			{ die('Error uploading file!'); }
		chmod($path, 0644);
		// Add version
		$query = 'INSERT INTO versions (plugin, versionstring, timestamp, description) VALUES ("'.$plugin.'", "'.$version.'", NOW(), "'.$description.'")';
		mysqli_query($db,$query);
		
		// Go to version page
		$query = 'SELECT id FROM versions WHERE plugin="'.$plugin.'" AND versionstring="'.$version.'"';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$id = $row['id'];
		$redirect_url = 'version.php?id='.$id.'';
		require('redirect.php');
	}
?>
