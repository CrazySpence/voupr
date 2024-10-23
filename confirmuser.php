<? require('headerdata.php'); ?>

<? $page_title = "TRUE"; ?>
<? require('database.php'); ?>
<?
	$user = mysqli_real_escape_string($db,strtolower($_GET['user']));
	$query = 'UPDATE users SET confirmed=TRUE WHERE username="'.$user.'"';
	mysqli_query($db,$query);
?>

<? $page_title = $longname.'Confirmation Successfull - VOUPR'; ?>
<? include('header.php'); ?>
	
	<h3>Account Confirmed!</h3>
	Now you may <a href="login.php">log in</a>.
	
<? include('footer.php'); ?>
