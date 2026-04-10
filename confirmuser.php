<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<?
	$user = strtolower($_GET['user']);
	db_run('UPDATE users SET confirmed=TRUE WHERE username=?', 's', $user);
?>

<? $page_title = $longname.'Confirmation Successfull - VOUPR'; ?>
<? include('header.php'); ?>
	
	<h3>Account Confirmed!</h3>
	Now you may <a href="login.php">log in</a>.
	
<? include('footer.php'); ?>
