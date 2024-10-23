<? require('headerdata.php'); ?>

<? $page_title = "Settings - VOUPR"; ?>

<?
	$post_login = 'settings.php';
	require('loggedin.php');
?>

<? include('header.php'); ?>

	<h3>Settings</h3>

	<div class="col floatleft">
		
	</div>

	<div class="col floatright">
		<div class="infobox">
			<b>Password:</b>
			<div style="height: 5px;"></div>
			<? if ($_GET['badoldpass']) { ?>
				<div class="error">
					Entry does not match your current password.
				</div>
			<? } ?>
			<? if ($_GET['passmismatch']) { ?>
				<div class="error">
					New password & confirmation do not match
				</div>
			<? } ?>
			<? if ($_GET['shortpass']) { ?>
				<div class="error">
					Password must be at least 6 characters long.
				</div>
			<? } ?>
			<form name="changepassword" method="post" action="dochangepassword.php">
				<table class="input">
					<tr>
						<td class="label">Current:</td>
						<td class="input"><input type="password" name="oldpassword"></td>
					</tr>
					<tr>
						<td class="label">New:</td>
						<td class="input"><input type="password" name="newpassword"></td>
					</tr>
					<tr>
						<td class="label">Re-enter:</td>
						<td class="input"><input type="password" name="confirmpassword"></td>
					</tr>
					<tr>
						<td class="submit" colspan="2"><input type="submit"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

<? include('footer.php'); ?>
