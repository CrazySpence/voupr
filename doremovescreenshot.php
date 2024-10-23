<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$plugin = mysqli_real_escape_string($db,$_GET['plugin']);
	$number = intval($_GET['number']);
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Plugin does not exist'); }
	
	// Check login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check user permissions
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	// Check number
	if ($number < 1 or $number > 3) { error('Invalid screenshot number.'); }
?>

<?
	// Remove file
	unlink('screenshots/'.$plugin.'-'.$number.'.png');
	
	// Go to plugin page
	$redirect_url = 'editplugin.php?plugin='.$plugin.'';
	require('redirect.php');
?>
