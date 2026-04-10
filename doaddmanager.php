<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>
<? require('session.php'); ?>

<?
	// Get form variables
	$user = $_POST['newmanager'];
	$plugin = strtolower($_POST['plugin']);
	
	// Require login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Invalid plugin.'); }
	
	// Check authorization
	if (!ismanager($plugin)) { error('You do not have permission to perform this operation'); }
	
	// Check user name
	if (!userexists($user)) { $badusername = TRUE; }
	
	// Do stuff
	if ($badusername)
	{
		// Return to page with errors
		$url = 'editplugin.php?plugin='.$plugin.'&';
		if ($badusername) { $url = $url.'badusername=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		if (!userismanager($user, $plugin))
		{
			db_run('INSERT INTO managers (username, pluginname) VALUES (?, ?)', 'ss', $user, $plugin);
		} else {
			// Return to page with errors
			$url = 'editplugin.php?plugin='.$plugin.'&dupmanager=TRUE';
			$redirect_url = substr($url, 0, -1);
			require('redirect.php');
		}
		
		// Return to edit page
		$redirect_url = 'editplugin.php?plugin='.$plugin;
		require('redirect.php');
	}
?>
