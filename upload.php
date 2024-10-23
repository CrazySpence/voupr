<? require('headerdata.php'); ?>

<? $page_title = "Upload - VOUPR";?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<? require('session.php'); ?>
<? $post_login = 'upload.php'; ?>
<? require('loggedin.php'); ?>

<? include('header.php'); ?>

<h3>Upload</h3>

<div class="right"><a href="newplugin.php">Add New Plugin</a></div>

<table class="pluginlist">
	<tr class="heading">
		<td>Plugin</td>
		<td>Version</td>
		<td>Description</td>
		<td>Upload</td>
	</tr>
	<?
		$query = 'SELECT plugins.*, MAX(versions.id) AS versionid
			FROM plugins, versions, managers
			WHERE managers.username="'.$user_name.'"
			AND plugins.name=managers.pluginname
			AND versions.plugin=plugins.name
			GROUP BY plugins.name
			ORDER BY plugins.longname ASC';
		$result = mysqli_query($db,$query);
	?>
	
	<? while($row = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><a href="plugin.php?name=<?=$row['name']?>"><?=$row['longname']?></a></td>
			<?
				$plugin = $row['name'];
				$versionid = $row['versionid'];
				$description = $row['description'];
			?>
			<td><?=vlink($versionid)?>
			<td><?=$description?></td>
			<td><a href="newversion.php?plugin=<?=$plugin?>">Upload</a></td>
		</tr>
	<? } ?>
</table>

<? include('footer.php'); ?>
