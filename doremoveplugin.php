<?
	$page_title = TRUE;
	require('database.php');
	require('session.php');
	require('utilities.php');

	// Get form variables
	$plugin = mysqli_real_escape_string($db,$_GET['plugin']);
	
	// Check user login
	$post_login = 'doremoveplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check plugin name
	if (pluginexists($pluginname)) { error('Plugin does not exist.'); }
	
	
	
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
			$query = 'DELETE FROM installed WHERE user="'.$user_sname.'" AND plugin="'.$plugin.'"';
			mysqli_query($db,$query);
		}
		
		// Return to My Plugins page
		$redirect_url = 'userplugins.php';
		include('redirect.php');
	}
?>
