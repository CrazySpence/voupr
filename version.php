<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	$id = mysqli_real_escape_string($db,$_GET['id']);
	$query = 'SELECT
				plugins.name,
				plugins.longname,
				versions.id,
				versions.versionstring,
				versions.description,
				DATE_FORMAT(DATE(timestamp), "%M %D, %Y") AS date
			FROM versions, plugins
			WHERE id="'.$id.'"
			AND plugins.name=versions.plugin';
	$result = mysqli_query($db,$query);
	if (!$row = mysqli_fetch_array($result)) {
		require('404redirect.php');
		exit();
	} else {
		$longname = $row['longname'];
		$desc = $row['description'];
	}
	$plugin = $row['name'];
	$dispname = $row['longname'];
	$version = $row['versionstring'];
	$versionid = $row['id'];
	$descform = desafe($row['description']);
	$descstatic = html($row['description']);
	$date = $row['date'];
	$query = 'SELECT versionstring, id FROM versions WHERE id=(SELECT MAX(id) FROM versions WHERE plugin="'.$plugin.'")';
	$result = mysqli_query($db,$query);
	$row = mysqli_fetch_array($result);
	$latest = $row['versionstring'];
	$latestid = $row['id'];
	if ($latest == $version) { $oldnew = 'newversion'; }
	else { $oldnew = 'oldversion'; }
?>

<? $page_title = $dispname.' - '.$version.' - VOUPR'; ?>
<? include('header.php'); ?>
	
	<? if (ismanager($plugin)) {?>
			<div class="editbutton">
				<a href="javascript:ChangelogForm();">Edit</a>
			</div>
	<? } ?>
	
	<script language="JavaScript">
		function ChangelogForm () {
			document.getElementById("changelog").style.display = "block";
			document.getElementById("changelogstatic").style.display = "none";
			document.getElementById("changelogform").style.display = "inline";
		}
	
		function ChangelogStatic () {
		<? if ($descform == '') { ?>
			document.getElementById("changelog").style.display = "none";
		<? } else { ?>
			document.getElementById("changelogstatic").style.display = "inline";
			document.getElementById("changelogform").style.display = "none";
		<? } ?>
		}
	</script>
	
	<h3><?=$dispname?> - Version <?=$version?></h3>
	
	<div class="main">
		<!--Begin Details-->
		<div class="longdesc" id="changelog">
			<div id="changelogstatic">
				<?=$descstatic?>
			</div>
			<div id="changelogform">
				<form name="editchangelog" method="post" action="doeditversion.php">
					<input type="hidden" name="id" value="<?=$versionid?>">
					<textarea name="description" class="fullwidth" rows=10><?=$descform?></textarea><br>
					<button type="button" onClick="ChangelogStatic();">Cancel</button>
					<input type="submit" label="Submit">
				</form>
			</div>
		</div>
		<script language="JavaScript">
			ChangelogStatic();
		</script>
		<!--End Details-->
	</div>
	
	<div class="info">
		<table class="info">
			<tr>
				<td class="label">Plugin:</td>
				<td class="info"><a href="plugin.php?name=<?=$plugin?>"><?=$dispname?></a></td>
			</tr>
			<tr>
				<td class="label">Version:</td>
				<td class="info"><?=vlink($versionid)?> / <?=vlink($latestid)?></td>
			</tr>
			<tr>
				<td class="label">Release Date:</td>
				<td class="info"><?=$date?></td>
			</tr>
			<tr>
				<td class="label">Download:</td>
				<td class="info"><a href="downloads/<?=$plugin?>-<?=$version?>.zip"><?=$plugin?>-<?=$version?>.zip</a></td>
			</tr>
		</table>
	</div>
	
<? include('footer.php'); ?>
