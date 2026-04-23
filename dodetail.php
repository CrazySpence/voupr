<? 
	$page_title = TRUE;
	require('database.php');
	require('utilities.php');

	csrf_verify();

	// Get form variables
	$plugin = $_POST['plugin'];
	$longdesc = $_POST['longdesc'];
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Plugin does not exist'); }
	
	// Check login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check user permissions
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	
	
	// Do stuff
	db_run('UPDATE plugins SET longdesc=? WHERE name=?', 'ss', $longdesc, $plugin);
	
	// Go to plugin page
	$redirect_url = 'editplugin.php?plugin='.$plugin.'';
	require('redirect.php');
?>
