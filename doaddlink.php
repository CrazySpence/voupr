<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('session.php'); ?>
<? require('utilities.php'); ?>

<?
	csrf_verify();

	// Get form variables
	$plugin = strtolower($_POST['plugin']);
	$type = intval($_POST['type']);
	$title = $_POST['title'];
	$link = $_POST['link'];
	
	// Require login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Invalid plugin.'); }
	
	// Check authorization
	if (!ismanager($plugin)) { error('You do not have permission to perform this operation'); }
	
	// Check type
	if ($type < 0 or $type > 3) { error('Invalid link type.'); }
	
	// Check title
	if ($title == '') { $badtitle = TRUE; }
	
	
	
	// Do stuff
	if ($badtitle)
	{
		// Return to page with errors
		$url = 'editplugin.php?plugin='.$plugin.'&';
		if ($badtitle) { $url = $url.'badtitle=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		// Add link to database
		db_run('INSERT INTO links (plugin, type, title, link) VALUES (?, ?, ?, ?)', 'siss', $plugin, $type, $title, $link);
	
		// Return to edit page
		$redirect_url = 'editplugin.php?plugin='.$plugin;
		require('redirect.php');
	}
?>
