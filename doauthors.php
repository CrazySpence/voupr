<? 
	$page_title = TRUE;
	require('database.php');
	require('utilities.php');

	// Get form variables
	$plugin = mysql_real_escape_string($_POST['plugin']);
	$authors = mysql_real_escape_string($_POST['authors']);
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Plugin does not exist'); }
	
	// Check login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check user permissions
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	
	
	// Do stuff
	$query = 'UPDATE plugins SET authors="'.$authors.'" WHERE name="'.$plugin.'"';
	mysqli_query($db,$query);
	
	// Go to plugin page
	$redirect_url = 'editplugin.php?plugin='.$plugin.'';
	require('redirect.php');
?>
