<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>
<? require('session.php'); ?>

<?
	// Get form variables
	$plugin = mysqli_real_escape_string($db,strtolower($_POST['plugin']));
	$dispname = mysqli_real_escape_string($db,$_POST['displayname']);
	$description = mysqli_real_escape_string($db,$_POST['description']);
	
	// Require login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check plugin name
	if (strlen($plugin) == 0) { $badpluginname = TRUE; }
	else
	{
		$query = 'SELECT name FROM plugins WHERE name="'.$plugin.'"';
		$result = mysqli_query($db,$query);
		if (!mysqli_fetch_array($result)) { require('404redirect.php'); }
	}
	
	// Check authorization
	if (!ismanager($plugin)) { require('404redirect.php'); }
	
	// Check display name
	if (strlen($dispname) == 0) { $baddispname = TRUE; }
	else
	{
		$query = 'SELECT name FROM plugins WHERE LOWER(longname)=LOWER("'.$dispname.'") AND name!="'.$plugin.'" LIMIT 1';
		$result = mysqli_query($db,$query);
		if (mysqli_fetch_array($result)) { $baddispname = TRUE; }
	}
?>

<?
	if ($badpluginname or $baddispname)
	{
		// Save form data
		require('session.php');
		$_SESSION['editplugin_dispname'] = $dispname;
		$_SESSION['editplugin_description'] = $description;
		// Return to page with errors
		$url = 'editplugin.php?';
		if ($baddispname) { $url = $url.'baddispname=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		// Set variables
		$plugin = $plugin;
		$longname = $dispname;
		$description = $description;
		// Update plugin info
		$query = 'UPDATE plugins SET longname="'.$longname.'", description="'.$description.'" WHERE name="'.$plugin.'"';
		mysqli_query($db,$query);
		
		// Redirect
		$redirect_url = 'editplugin.php?plugin='.$plugin;
		require('redirect.php');
	}
?>
