<? require('component.php'); ?>
<? require('session.php'); ?>

<? if ($page_title != 'Login - VOUPR' and $page_title != 'Sign Out - VOUPR')
	{ $_SESSION['post_login'] = $_SERVER['REQUEST_URI']; } ?>

<html>
<head>
	<title><?=$page_title?></title>
	<link type="text/css" rel="stylesheet" href="https://<?php echo $SERVER ?>/styles.css">
</head>
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try 
		{
			var pageTracker = _gat._getTracker("UA-15988534-1");
			pageTracker._trackPageview();
		} catch(err) {}
	</script>
<body>
	<div class="body">
		<? include('navbar.php'); ?>
		<div class="content">
