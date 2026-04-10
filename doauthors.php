<? 
	$page_title = TRUE;
	require('database.php');
	require('utilities.php');

	// Get form variables
	$plugin = $_POST['plugin'];
	$authors = $_POST['authors'];
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Plugin does not exist'); }
	
	// Check login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check user permissions
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	
	
	// Do stuff
	db_run('UPDATE plugins SET authors=? WHERE name=?', 'ss', $authors, $plugin);
	
	// Go to plugin page
	$redirect_url = 'editplugin.php?plugin='.$plugin.'';
	require('redirect.php');
?>
