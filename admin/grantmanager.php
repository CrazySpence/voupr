<? require('../headerdata.php'); ?>

<? $page_title = "VO Unofficial Plugin Repository";?>
<? include('../header.php'); ?>
<? require('admin.php'); ?>

<div class="editbutton">
	<a href=".">Back</a>
</div>

<h3>Grant Manager Status</h3>

<div class="main">
	Grant the given user manegerial status of a particular plugin.<br><br>You must enter a valid plugin ID and user ID.
</div>

<div class="sidebar floatright">
	<div class="infobox">
		<form name="grantmanager" method="post" action="dograntmanager.php">
			<? if ($_GET['badplugin']) { ?>
				<div class="error">
					Plugin does not exist.
				</div>
			<? } ?>
			<? if ($_GET['baduser']) { ?>
				<div class="error">
					User does not exist.
				</div>
			<? } ?>
			<table class="input">
				<tr>
					<td class="label">Plugin:</td>
					<td class="input"><input type="text" name="plugin" value="<?=$_GET['plugin']?>"></td>
				</tr>
				<tr>
					<td class="label">User:</td>
					<td class="input"><input type="text" name="user" value="<?=$_GET['user']?>"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit"></td>
				</tr>
			</table>
			<? if ($_GET['success']) { ?>
				<div class="success">
					Manager added.
				</div>
			<? } ?>
		</form>
	</div>
</div>

<? include('../footer.php'); ?>
