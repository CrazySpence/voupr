<? require('headerdata.php'); ?>

<? $page_title = "Register - VOUPR"; ?>
<? include('header.php'); ?>

<h3>Register</h3>

<div class="registerinfo">
Registering will allow you to:
<ul>
	<li> Manage your plugins
	<li> Add new plugins to the repository
	<li> Rate plugins
	<li> Use the auto-updater
	<li> And more...
</ul>
</div>

<div class="register">
	<? if ($_GET['badusername']) { ?>
		<div class="registererror">
			Username already in use.
		</div>
	<? } ?>
	<? if ($_GET['dupemail']) { ?>
		<div class="registererror">
			Email address already in use.
		</div>
	<? } ?>
	<? if ($_GET['bademail']) { ?>
		<div class="registererror">
			Invalid email address.
		</div>
	<? } ?>
	<? if ($_GET['badpassword']) { ?>
		<div class="registererror">
			Password must contain at least 6 characters.
		</div>
	<? } ?>
	<? if ($_GET['diffpasswords']) { ?>
		<div class="registererror">
			Passwords do not match.
		</div>
	<? } ?>
	<form name="register" method="post" action="doregister.php">
		<table class="input">
			<tr>
				<td class="label">Username:</td>
				<td class="input"><input type="text" name="username"></td>
			</tr>
			<tr>
				<td class="label">E-mail:</td>
				<td class="input"><input type="text" name="email"></td>
			</tr>
			<tr>
				<td class="label">Password:</td>
				<td class="input"><input type="password" name="password"></td>
			</tr>
			<tr>
				<td class="label">Re-enter:</td>
				<td class="input"><input type="password" name="passcheck"></td>
			</tr>
			<tr>
				<td class="submit" colspan=2><input type="submit"></td>
			</tr>
		</table>
	</form>
</div>

<? include('footer.php'); ?>
