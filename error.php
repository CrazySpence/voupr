<? require('headerdata.php'); ?>

<? $page_title = "Error - VOUPR"; ?>
<? require('session.php'); ?>

<? include('header.php'); ?>

<h3>Permission Denied</h3>
<div class="error"><?=$_SESSION['error']?></div>
<? unset($_SESSION['error']); ?>

<? include('footer.php'); ?>
