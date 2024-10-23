<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>
<? require('session.php'); ?>

<?
	// Get form variables
	$plugin = mysqli_real_escape_string($db,strtolower($_GET['plugin']));
	$user = mysqli_real_escape_string($db,$_GET['user']);
	
	// Require login
	$post_login = 'doremovemanager.php?plugin='.$plugin.'&user='.$user;
	require('loggedin.php');
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Invalid plugin.'); }
	
	// Check authorization
	if (!ismanager($plugin)) { error('You do not have permission to perform this operation'); }
	
	// Check user name
	if (!userismanager($user, $plugin)) { $badusername = TRUE; }
	
	// Check number of managers
	$query = 'SELECT COUNT(username) AS num FROM managers WHERE pluginname="'.$plugin.'"';
	$result = mysqli_query($db,$query);
	$row = mysqli_fetch_array($result);
	if ($row['num'] == '1') { $lastmanager = TRUE; }



	// Do stuff
	if ($badusername or $lastmanager)
	{
		// Return to page with errors
		$url = 'editplugin.php?plugin='.$plugin.'&';
		if ($badusername) { $url = $url.'badusername=TRUE&'; }
		if ($lastmanager) { $url = $url.'lastmanager=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		// Set variables
		$plugin = $plugin;
		$user = $user;
		$query = 'DELETE FROM managers WHERE username="'.$user.'" AND pluginname="'.$plugin.'"';
		mysqli_query($db,$query);
		
		// Return to edit page
		if ($user != $user_sname)
			{ $redirect_url = 'editplugin.php?plugin='.$plugin; }
		else
			{ $redirect_url = 'plugin.php?plugin='.$plugin; }
		require('redirect.php');
	}
?>
