<? require('headerdata.php'); ?>

<? $page_title = "Submitting Rating - VOUPR"; ?>
<? require('database.php'); ?>
<? require('session.php'); ?>

<?
	// Get form variables
	$plugin = mysqli_real_escape_string($db,$_GET['plugin']);
	$rating = mysqli_real_escape_string($db,$_GET['rating']);
	
	// Check user login
	$post_login = 'dorating.php?plugin='.$plugin.'&rating='.$rating.'';
	require('loggedin.php');
	
	// Check plugin name
	if (strlen($plugin) == 0) { $badpluginname = TRUE; }
	else
	{
		$query = 'SELECT name FROM plugins WHERE name="'.$plugin.'" LIMIT 1';
		$result = mysqli_query($db,$query);
		if (!($row = mysqli_fetch_array($result))) { $badpluginname = TRUE; }
	}
	
	// Check rating
	if ($rating != '0' and $rating != '2' and $rating != '4' and $rating != '6' and $rating != '8' and $rating != '10') { $badrating = true; }
?>

<?
	if ($badpluginname or $badversion)
	{
		// Return to page with errors
		include('404redirect.php');
	} else {
		// Set variables
		$plugin = $plugin;
		$rating = $rating;
		// Update version
		$query = 'SELECT rating FROM ratings WHERE user="'.$user_sname.'" AND plugin="'.$plugin.'"';
		$result = mysqli_query($db,$query);
		if ($row = mysqli_fetch_array($result))
		{
			$query = 'UPDATE ratings SET rating="'.$rating.'" WHERE user="'.$user_sname.'" AND plugin="'.$plugin.'"';
		}
		else
		{
			$query = 'INSERT INTO ratings (user, plugin, rating) VALUES ("'.$user_sname.'", "'.$plugin.'", "'.$rating.'")';
		}
		mysqli_query($db,$query);
		
		$redirect_url = 'plugin.php?name='.$plugin;
		include('redirect.php');
	}
?>
