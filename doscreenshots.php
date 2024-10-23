<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get form variables
	$plugin = mysqli_real_escape_string($db,$_POST['plugin']);
	$file1 = $_FILES['screenshot1'];
	$file2 = $_FILES['screenshot2'];
	$file3 = $_FILES['screenshot3'];
	
	// Check plugin name
	if (!pluginexists($plugin)) { error('Plugin does not exist'); }
	
	// Check login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check user permissions
	if (!ismanager($plugin)) { error('You do not have permission to perform this action.'); }
	
	// Check file 1
	if ($file1['error'] > 0) { $badfile1 = TRUE; }
	else {
		$type1 = substr($file1['name'], -4);
		if ($file1['size'] > 1000000) { $bigfile1 = TRUE; }
		if ($type1 != '.png') { $badfiletype1 = TRUE; }
	}
	
	// Check file 2
	if ($file2['error'] > 0) { $badfile2 = TRUE; }
	else {
		$type2 = substr($file2['name'], -4);
		if ($file2['size'] > 1000000) { $bigfile2 = TRUE; }
		if ($type2 != '.png') { $badfiletype2 = TRUE; }
	}
	
	// Check file 3
	if ($file3['error'] > 0) { $badfile3 = TRUE; }
	else {
		$type3 = substr($file3['name'], -4);
		if ($file3['size'] > 1000000) { $bigfile3 = TRUE; }
		if ($type3 != '.png') { $badfiletype3 = TRUE; }
	}
?>

<?
	if ($bigfile1 or $badfiletype1 or
			$bigfile2 or $badfiletype2 or
			$bigfile3 or $badfiletype3)
	{
		// Return to page with errors
		$url = 'editplugin.php?plugin='.$plugin.'&';
		if ($bigfile1) { $url = $url.'bigfile1=TRUE&'; }
		if ($badfiletype1) { $url = $url.'badfiletype1=TRUE&'; }
		if ($bigfile2) { $url = $url.'bigfile2=TRUE&'; }
		if ($badfiletype2) { $url = $url.'badfiletype2=TRUE&'; }
		if ($bigfile3) { $url = $url.'bigfile3=TRUE&'; }
		if ($badfiletype3) { $url = $url.'badfiletype3=TRUE&'; }
		$redirect_url = substr($url, 0, -1);
		require('redirect.php');
	} else {
		// Upload files
		if (!$badfile1){
			$path = 'screenshots/'.$plugin.'-1'.$type1;
			if (!move_uploaded_file($file1['tmp_name'], $path))
				{ error('Error uploading screenshot 1.'); }
			chmod($path, 0644);
		}
		if (!$badfile2) {
			$path = 'screenshots/'.$plugin.'-2'.$type2;
			if (!move_uploaded_file($file2['tmp_name'], $path))
				{ error('Error uploading screenshot 2.'); }
			chmod($path, 0644);
		}
		if (!$badfile3) {
			$path = 'screenshots/'.$plugin.'-3'.$type3;
			if (!move_uploaded_file($file3['tmp_name'], $path))
				{ error('Error uploading screenshot 3.'); }
			chmod($path, 0644);
		}
		
		// Go to plugin page
		$redirect_url = 'editplugin.php?plugin='.$plugin.'';
		require('redirect.php');
	}
?>
