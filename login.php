<? require('headerdata.php'); ?>

<? $page_title = 'Login - VOUPR'; ?>
<? include('header.php'); ?>

<h3>Login</h3>

<div class="logininfo">
If you have forgotten your password, please contact the admin to have it reset.<br><br>
Clicking "Remember Me" will create a login cookie that lasts one year from the date of login, so do not check this option if you are using a public terminal.
</div>

<div class="login">
	<? if ($_GET['badlogin']) { ?>
		<div class="loginerror">
			Incorrect username or password.
		</div>
	<? } ?>
	<form name="login" method="post" action="dologin.php">
		<table class="input">
			<tr>
				<td class="label">Username:</td>
				<td class="input"><input type="text" name="username"></td>
			</tr>
			<tr>
				<td class="label">Password:</td>
				<td class="input"><input type="password" name="password"></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td><input type="checkbox" name="remember"> Remember me</td>
			</tr>
			<tr>
				<td class="submit" colspan=2><input type="submit"></td>
			</tr>
		</table>
	</form>
</div>

<? include('footer.php'); ?>
