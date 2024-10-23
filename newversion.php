<? require('headerdata.php'); ?>

<? $page_title = "Upload Version - VOUPR"; ?>
<? require('loggedin.php'); ?>
<? require('utilities.php'); ?>

<?
	$plugin = $_GET['plugin'];
	// Load form data
	require('session.php');
	$version = $_SESSION['newversion_version'];
	$description = desafe($_SESSION['newversion_description']);
	unset($_SESSION['newversion_version']);
	unset($_SESSION['newversion_description']);
?>

<? include('header.php'); ?>

<h3>Upload New Version</h3>

<div class="versioninfo">
	Please make sure you are uploading a ZIP file containing all your plugin's files inside the folder you want installed in the plugins directory.  For example:
	<ul>
		<li> irrelevant.zip
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

<div class="newversion">
	<? if ($_GET['badplugin']) { ?>
		<div class="versionerror">
			Invalid plugin.
		</div>
	<? } ?>
	<? if ($_GET['badfile']) { ?>
		<div class="versionerror">
			Error uploading file.
		</div>
	<? } ?>
	<? if ($_GET['bigfile']) { ?>
		<div class="versionerror">
			File cannot exceed 10MB.
		</div>
	<? } ?>
	<? if ($_GET['badfiletype']) { ?>
		<div class="versionerror">
			Upload must meet guidelines on left.
		</div>
	<? } ?>
	<? if ($_GET['badversion']) { ?>
		<div class="versionerror">
			You must enter a valid version identifier.
		</div>
	<? } ?>
	<? if ($_GET['dupversion']) { ?>
		<div class="versionerror">
			Version already exists.
		</div>
	<? } ?>
	<form name="newversion" method="post" action="donewversion.php" enctype="multipart/form-data">
		<table class="input">
			<tr>
				<td class="label">Plugin:</td>
				<td class="input"><a href="plugin.php?name=<?=$plugin?>"><?=$plugin?></a></td>
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
				<td class="label">Changes:</td>
				<td class="input"><textarea name="description"><?=$description?></textarea></td>
			</tr>
			<tr>
				<input type="hidden" name="plugin" value="<?=$plugin?>">
				<td class="submit" colspan=2><input type="submit"></td>
			</tr>
		</table>
	</form>
</div>

<? include('footer.php'); ?>
