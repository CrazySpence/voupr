<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	csrf_verify();

	// Get form variables
	$id = intval($_POST['id']);
	$description = $_POST['description'];
	
	// Get plugin name
	$result = db_run('SELECT plugin FROM versions WHERE id=?', 'i', $id);
	$row = mysqli_fetch_array($result);
	$plugin = $row['plugin'];
	
	// Check user
	$post_login = 'version.php?id='.$plugin;
	require('loggedin.php');
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	// Do stuff
	db_run('UPDATE versions SET description=? WHERE id=?', 'si', $description, $id);
	
	$redirect_url = 'version.php?id='.$id.'';
	require('redirect.php');
?>
