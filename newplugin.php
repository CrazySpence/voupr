<? require('headerdata.php'); ?>

<? $page_title = "Add Plugin - VOUPR"; ?>
<? require('loggedin.php'); ?>

<?
	// Load form data
	require('session.php');
	$name = $_SESSION['newplugin_name'];
	$dispname = $_SESSION['newplugin_dispname'];
	$description = $_SESSION['newplugin_description'];
	$version = $_SESSION['newplugin_version'];
	unset($_SESSION['newplugin_name']);
	unset($_SESSION['newplugin_dispname']);
	unset($_SESSION['newplugin_description']);
	unset($_SESSION['newplugin_version']);
?>

<? include('header.php'); ?>

<h3>Add New Plugin</h3>

<div class="plugininfo">
	Please make sure you are uploading a ZIP file containing all your plugin's files inside the folder you want installed in the plugins directory.  For example:
	<ul>
		<li> whatever.zip
		<ul>
			<li> myplugin
			<ul>
				<li> main.lua
				<li> file1.lua
				<li> file2.lua
				<li> file3.lua
				<li> ...
			</ul>
		</ul>
	</ul>
	<div class="warning">
		If these restrictions are not met, your plugin will not work properly with the auto-updater.
	</div>
</div>

<div class="newplugin">
	<? if ($_GET['badpluginname']) { ?>
		<div class="pluginerror">
			Please choose a different plugin name.
		</div>
	<? } ?>
	<? if ($_GET['pluginnamehasspace']) { ?>
		<div class="pluginerror">
			Plugin names cannot contain spaces.
		</div>
	<? } ?>
	<? if ($_GET['baddispname']) { ?>
		<div class="pluginerror">
			Please choose a different display name.
		</div>
	<? } ?>
	<? if ($_GET['badfile']) { ?>
		<div class="pluginerror">
			Error uploading file.
		</div>
	<? } ?>
	<? if ($_GET['bigfile']) { ?>
		<div class="pluginerror">
			File cannot exceed 10MB.
		</div>
	<? } ?>
	<? if ($_GET['badversion']) { ?>
		<div class="pluginerror">
			You must enter a version identifier.
		</div>
	<? } ?>
	<? if ($_GET['badfiletype']) { ?>
		<div class="pluginerror">
			Upload must meet guidelines on left.
		</div>
	<? } ?>
	<form name="newplugin" method="post" action="donewplugin.php" enctype="multipart/form-data">
		<table class="input">
			<tr>
				<td class="label">Plugin ID:</td>
				<td class="input"><input type="text" name="pluginname" value="<?=$name?>"></td>
			</tr>
			<tr>
				<td class="label">Display Name:</td>
				<td class="input"><input type="text" name="displayname" value="<?=$dispname?>"></td>
			</tr>
			<tr>
				<td class="label">Description:</td>
				<td class="input"><textarea name="description" ><?=$description?></textarea></td>
			</tr>
			<tr>
				<td class="label">Upload:</td>
				<td class="input"><input type="file" name="upload" id="upload"></td>
			</tr>
			<tr>
				<td class="label">Version:</td>
				<td class="input"><input type="text" name="version" value="<?=$version?>"></td>
			</tr>
			<tr>
				<td class="submit" colspan=2><input type="submit"></td>
			</tr>
		</table>
	</form>
</div>

<? include('footer.php'); ?>
