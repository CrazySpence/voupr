<?
	function add ($string) { echo $string."\n"; }	
	
	$page_title = TRUE;
	require('database.php');
	require('utilities.php');

	// Gather data
	$sort = 'longname ASC';
	if ($_GET['sort'] == 'name') { $sort = 'longname ASC'; }
	if ($_GET['sort'] == 'rating') { $sort = 'rating DESC'; }
	if ($_GET['sort'] == 'users') { $sort = 'users DESC'; }
	$condition_sql = '';
	$condition_params = [];
	$condition_types = '';
	require('pluginlist.php');
	
	// Create XML
	add('<?xml version="1.0"?>');
	add('<plugins>');
	while($row = mysqli_fetch_array($result))
	{
		add('	<plugin>');
		add('		<name>'.desafe($row['name']).'</name>');
		add('		<dispname>'.desafe($row['longname']).'</dispname>');
		add('		<rating>'.$row['rating'].'</rating>');
		add('		<users>'.$row['users'].'</users>');
		add('		<description>'.desafe($row['description']).'</description>');
		add('	</plugin>');
	}
	add('</plugins>');

	exit();
?>
