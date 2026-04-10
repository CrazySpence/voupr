<?
	function add ($string) { echo $string."\n"; }	
	
	$page_title = TRUE;
	require('database.php');
	require('userauth.php');
	require('utilities.php');

	// Set variables
	$name = $_GET['plugin'];
	$result = db_run('SELECT * FROM plugins WHERE name=?', 's', $name);
	$row = mysqli_fetch_array($result);
	$dispname = $row['longname'];
	$desc = $row['description'];
	
	// Get version table info
	$result = db_run(
		'SELECT id, versionstring,
		        DATE_FORMAT(DATE(timestamp), "%Y") AS year,
		        DATE_FORMAT(DATE(timestamp), "%m") AS month,
		        DATE_FORMAT(DATE(timestamp), "%d") AS day,
		        DATE_FORMAT(DATE(timestamp), "%j") AS dayofyear,
		        description
		 FROM versions WHERE plugin=? ORDER BY id DESC',
		's', $name
	);
	$oldnew = 'newversion';

	// Create XML
	add('<?xml version="1.0"?>');
	add('<versions>');
	while($row = mysqli_fetch_array($result))
	{
		add('	<version>');
		add('		<id>'.$row['id'].'</id>');
		add('		<label>'.desafe($row['versionstring']).'</label>');
		add('		<date>');
		add('			<year>'.$row['year'].'</year>');
		add('			<month>'.$row['month'].'</month>');
		add('			<day>'.$row['day'].'</day>');
		add('			<absdate>'.(intval($row['year'])*367 + intval($row['dayofyear'])).'</absdate>');
		add('		</date>');
		add('		<changes>'.desafe($row['description']).'</changes>');
		add('	</version>');
	}
	add('</versions>');
	exit();
?>
