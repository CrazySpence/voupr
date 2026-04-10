<? require('headerdata.php'); ?>

<? $page_title = "Submitting Rating - VOUPR"; ?>
<? require('database.php'); ?>
<? require('session.php'); ?>

<?
	// Get form variables
	$plugin = $_GET['plugin'];
	$rating = intval($_GET['rating']);
	
	// Check user login
	$post_login = 'dorating.php?plugin='.$plugin.'&rating='.$rating.'';
	require('loggedin.php');
	
	// Check plugin name
	if (strlen($plugin) == 0) { $badpluginname = TRUE; }
	else
	{
		$result = db_run('SELECT name FROM plugins WHERE name=? LIMIT 1', 's', $plugin);
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
		$result = db_run('SELECT rating FROM ratings WHERE user=? AND plugin=?', 'ss', $user_sname, $plugin);
		if ($row = mysqli_fetch_array($result))
		{
			db_run('UPDATE ratings SET rating=? WHERE user=? AND plugin=?', 'iss', $rating, $user_sname, $plugin);
		}
		else
		{
			db_run('INSERT INTO ratings (user, plugin, rating) VALUES (?, ?, ?)', 'ssi', $user_sname, $plugin, $rating);
		}
		
		$redirect_url = 'plugin.php?name='.$plugin;
		include('redirect.php');
	}
?>
