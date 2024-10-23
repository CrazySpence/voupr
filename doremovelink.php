<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$id = mysql_real_escape_string($_GET['id']);
	
	// Get plugin
	$query = 'SELECT plugin FROM links WHERE id="'.$id.'"';
	$result = mysqli_query($db,$query);
	if (!($row = mysqli_fetch_array($result))) { error('Bad link id.'); }
	else { $plugin = $row['plugin']; }
	
	// Require login
	$post_login = 'doremovelink.php?plugin='.$plugin.'&user='.$user;
	require('loggedin.php');
	
	// Check authorization
	if (!ismanager($plugin)) { error('You do not have permission to perform this operation'); }



	// Do stuff
	$query = 'DELETE FROM links WHERE id="'.$id.'"';
	mysqli_query($db,$query);
	
	// Return to edit page
	$redirect_url = 'editplugin.php?plugin='.$plugin;
	require('redirect.php');
?>
