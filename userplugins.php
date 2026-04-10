<? require('headerdata.php'); ?>

<? $page_title = "My Plugins - VOUPR";?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<? require('session.php'); ?>
<? $post_login = 'userplugins.php'; ?>
<? require('loggedin.php'); ?>

<? include('header.php'); ?>

<h3>My Plugins</h3>

<table class="pluginlist">
	<tr class="heading">
		<td>Update</td>
		<td>Plugin</td>
		<td>Installed</td>
		<td>Latest</td>
		<td>Remove</td>
	</tr>
	<?
		$result = db_run(
			'SELECT plugins.*, installed.version AS installed
			 FROM plugins, installed, versions
			 WHERE installed.user=?
			   AND installed.plugin=plugins.name
			   AND plugins.name=versions.plugin
			   AND installed.version=versions.id',
			's', $user_sname
		);
	?>
	<? while($row = mysqli_fetch_array($result)) { ?>
		<?
			$installed = $row['installed'];
			$plugin = $row['name'];
			$dispname = $row['longname'];
			$rresult = db_run('SELECT MAX(id) AS latest FROM versions WHERE plugin=?', 's', $plugin);
			$rrow = mysqli_fetch_array($rresult);
			$latest = $rrow['latest'];
		?>
		<tr>
			<td></td>
			<td><a href="plugin.php?name=<?=$plugin?>"><?=$dispname?></a></td>
			<td><?=vlink($installed)?></td>
			<td><?=vlink($latest)?></td>
			<td class="center"><a class="delete" href="doremoveplugin.php?plugin=<?=$plugin?>">X</a></td>
		</tr>
	<? } ?>
</table>

<? include('footer.php'); ?>
