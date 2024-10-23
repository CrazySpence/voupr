<?
	$page_title = TRUE;
	require('database.php');
	require('session.php');
	require('utilities.php');

	// Get form variables
	$plugin = mysqli_real_escape_string($db,$_GET['plugin']);
	$version = mysqli_real_escape_string($db,$_GET['version']);
	
	// Check user login
	$post_login = 'doaddplugin.php?plugin='.$plugin.'&version='.$version.'';
	require('loggedin.php');
	
	// Check plugin name
	if (pluginexists($pluginname)) { error('Plugin does not exist.'); }
	
	// Check version
	if (strlen($version) == 0) { $badversion = TRUE; }
	else
	{
		$query = 'SELECT id FROM versions WHERE plugin="'.$plugin.'" AND id="'.$version.'" LIMIT 1';
		$result = mysqli_query($db,$query);
		if (!mysqli_fetch_array($result)) { $badversion = TRUE; }
	}
	
	
	
	// Do stuff
	if ($badpluginname or $badversion)
	{
		// Return to page with errors
		include('404redirect.php');
	} else {
		// Set variables
		$plugin = $plugin;
		$version = $version;
		// Update version
		$query = 'SELECT version FROM installed WHERE user="'.$user_sname.'" AND plugin="'.$plugin.'"';
		$result = mysqli_query($db,$query);
		if ($row = mysqli_fetch_array($result))
		{
			$query = 'UPDATE installed SET version="'.$version.'" WHERE user="'.$user_sname.'" AND plugin="'.$plugin.'"';
		}
		else
		{
			$query = 'INSERT INTO installed (user, plugin, version) VALUES ("'.$user_sname.'", "'.$plugin.'", "'.$version.'")';
		}
		mysqli_query($db,$query);
		
		$redirect_url = 'plugin.php?name='.$plugin;
		include('redirect.php');
	}
?>
