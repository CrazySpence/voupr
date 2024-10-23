<? require('component.php'); ?>
<? require('userauth.php'); ?>

<div class="navbar">
	<table class="navbar"><tr>
		<td class="first">
			<a class="navlink" href="<?=$SERVER?>.">Home</a> |
			<a class="navlink" href="<?=$SERVER?>list.php">List</a> |
			<a class="navlink" href="<?=$SERVER?>userplugins.php">My Plugins</a> |
			<a class="navlink" href="<?=$SERVER?>upload.php">Upload</a> |
                        <a class="navlink" href="<?=$SERVER?>active.php">In Game</a>
		</td>
		<td class="spacerone">&#183</td>
		<? if ($user_loggedin) { ?>
			<td>
				<a class="navlink" href="<?=$SERVER?>settings.php">Settings</a> |
				<a class="navlink" href="<?=$SERVER?>logout.php">Sign out</a>
			</td>
		<? } else { ?>
			<td>
				<a class="navlink" href="<?=$SERVER?>login.php">Sign in</a> or
				<a class="navlink" href="<?=$SERVER?>register.php">Register</a>
			</td>
		<? } ?>
		<td class="spacer">&#183</td>
		<td>
			<form name="search" method="get" action="search.php">
				Search:
				<input type="text" name="search" class="searchfield">
			</form>
	</tr></table>
</div>
