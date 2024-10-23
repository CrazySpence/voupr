<? require('../headerdata.php'); ?>

<? $page_title = "VOUPR Admin - Reset Password";?>
<? include('../header.php'); ?>
<? require('admin.php'); ?>

<div class="editbutton">
	<a href=".">Back</a>
</div>

<h3>Reset Password</h3>

<div class="main">
	Reset the given user's password<br><br>You must enter a valid user ID and password.
</div>

<div class="sidebar floatright">
	<div class="infobox">
		<form name="resetpassword" method="post" action="doresetpassword.php">
			<? if ($_GET['baduser']) { ?>
				<div class="error">
					User does not exist.
				</div>
			<? } ?>
			<? if ($_GET['badpassword']) { ?>
				<div class="error">
					Invalid password.
				</div>
			<? } ?>
			<table class="input">
				<tr>
					<td class="label">User:</td>
					<td class="input"><input type="text" name="user" value="<?=$_GET['user']?>"></td>
				</tr>
				<tr>
					<td class="label">Password:</td>
					<td class="input"><input type="password" name="password"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit"></td>
				</tr>
			</table>
			<? if ($_GET['success']) { ?>
				<div class="success">
					Password reset.
				</div>
			<? } ?>
		</form>
	</div>
</div>

<? include('../footer.php'); ?>
