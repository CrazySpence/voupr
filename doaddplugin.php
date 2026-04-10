<?
	$page_title = TRUE;
	require('database.php');
	require('session.php');
	require('utilities.php');

	// Get form variables
	$plugin = $_GET['plugin'];
	$version = intval($_GET['version']);
	
	// Check user login
	$post_login = 'doaddplugin.php?plugin='.$plugin.'&version='.$version.'';
	require('loggedin.php');
	
	// Check plugin name
	if (pluginexists($pluginname)) { error('Plugin does not exist.'); }
	
	// Check version
	if (strlen($version) == 0) { $badversion = TRUE; }
	else
	{
		$result = db_run('SELECT id FROM versions WHERE plugin=? AND id=? LIMIT 1', 'si', $plugin, $version);
		if (!mysqli_fetch_array($result)) { $badversion = TRUE; }
	}
	
	
	
	// Do stuff
	if ($badpluginname or $badversion)
	{
		// Return to page with errors
		include('404redirect.php');
	} else {
		$result = db_run('SELECT version FROM installed WHERE user=? AND plugin=?', 'ss', $user_sname, $plugin);
		if ($row = mysqli_fetch_array($result))
		{
			db_run('UPDATE installed SET version=? WHERE user=? AND plugin=?', 'iss', $version, $user_sname, $plugin);
		}
		else
		{
			db_run('INSERT INTO installed (user, plugin, version) VALUES (?, ?, ?)', 'ssi', $user_sname, $plugin, $version);
		}
		
		$redirect_url = 'plugin.php?name='.$plugin;
		include('redirect.php');
	}
?>
