<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$id = intval($_POST['id']);
	$description = mysqli_real_escape_string($db,$_POST['description']);
	
	// Get plugin name
	$query = 'SELECT plugin FROM versions WHERE id="'.$id.'"';
	$result = mysqli_query($db,$query);
	$row = mysqli_fetch_array($result);
	$plugin = $row['plugin'];
	
	// Check user
	$post_login = 'version.php?id='.$plugin;
	require('loggedin.php');
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	// Do stuff
	$query = 'UPDATE versions SET description="'.$description.'" WHERE id="'.$id.'"';
	mysqli_query($db,$query);
	
	$redirect_url = 'version.php?id='.$id.'';
	require('redirect.php');
?>
