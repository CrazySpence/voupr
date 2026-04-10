<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$id = intval($_GET['id']);
	
	// Get plugin
	$result = db_run('SELECT plugin FROM links WHERE id=?', 'i', $id);
	if (!($row = mysqli_fetch_array($result))) { error('Bad link id.'); }
	else { $plugin = $row['plugin']; }
	
	// Require login
	$post_login = 'doremovelink.php?plugin='.$plugin.'&user='.$user;
	require('loggedin.php');
	
	// Check authorization
	if (!ismanager($plugin)) { error('You do not have permission to perform this operation'); }



	// Do stuff
	db_run('DELETE FROM links WHERE id=?', 'i', $id);
	
	// Return to edit page
	$redirect_url = 'editplugin.php?plugin='.$plugin;
	require('redirect.php');
?>
