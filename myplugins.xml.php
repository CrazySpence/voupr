<?
	function add ($string) { echo $string."\n"; }	
	
	// Get data
	$page_title = TRUE;
	require('database.php');
	require('utilities.php');
	require('loggedin.php');
	$query = 'SELECT plugins.*, installed.version AS installed
			FROM plugins, installed, versions
			WHERE installed.user="'.$user_sname.'"
				AND installed.plugin=plugins.name
				AND plugins.name=versions.plugin
				AND installed.version=versions.id';
	$result = mysqli_query($db,$query);

	// Create XML
	add('<?xml version="1.0"?>');
	add('<myplugins>');
	while($row = mysqli_fetch_array($result))
	{
			$installed = $row['installed'];
			$plugin = $row['name'];
			$dispname = $row['longname'];
			$rquery = 'SELECT MAX(id) AS latest FROM versions WHERE plugin="'.$plugin.'"';
			$rresult = mysql_query($rquery);
			$rrow = mysql_fetch_array($rresult);
			$latest = $rrow['latest'];
			// Write
			add('	<plugin>');
			add('		<name>'.desafe($plugin).'</name>');
			add('		<dispname>'.desafe($dispname).'</dispname>');
			add('		<installed>'.$installed.'</installed>');
			add('		<latest>'.$latest.'</installed>');
			add('	</plugin>');
	}
	add('</myplugins>');
	
	exit()
?>
