<? require('../headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('../database.php'); ?>
<? require('../utilities.php'); ?>
<? require('../session.php'); ?>
<? require('admin.php'); ?>

<?
	// Get form variables
	$plugin = safe(strtolower($_POST['plugin']));
	$user = safe($_POST['user']);
	
	// Check plugin name
	if (!pluginexists($plugin)) { $badplugin = TRUE; }
	
	// Check user name
	if (!userexists($user)) { $baduser = TRUE; }
	
	// Do stuff
	if ($baduser or $badplugin)
	{
		// Return to page with errors
		$url = 'grantmanager.php?plugin='.$plugin.'&user='.$user.'&';
		if ($badplugin) { $url = $url.'badplugin=TRUE&'; }
		if ($baduser) { $url = $url.'baduser=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('../redirect.php');
	} else {
		if (!userismanager($user, $plugin))
		{
			$query = 'INSERT INTO managers (username, pluginname) VALUES ("'.$user.'", "'.$plugin.'")';
			mysqli_query($db,$query);
		}
		
		// Return to page
		$redirect_url = 'grantmanager.php?success=TRUE';
		require('../redirect.php');
	}
?>
