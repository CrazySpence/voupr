<?
	$page_title = TRUE;
	require('database.php');
	require('session.php');
	require('utilities.php');

	// Get form variables
	$plugin = $_GET['plugin'];
	
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
		$result = db_run('SELECT version FROM installed WHERE user=? AND plugin=?', 'ss', $user_sname, $plugin);
		if ($row = mysqli_fetch_array($result))
		{
			db_run('DELETE FROM installed WHERE user=? AND plugin=?', 'ss', $user_sname, $plugin);
		}
		
		// Return to My Plugins page
		$redirect_url = 'userplugins.php';
		include('redirect.php');
	}
?>
