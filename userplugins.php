<? require('headerdata.php'); ?>

<? $page_title = "My Plugins - VOUPR";?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<? require('session.php'); ?>
<? $post_login = 'userplugins.php'; ?>
<? require('loggedin.php'); ?>

<? include('header.php'); ?>

<h3>My Plugins</h3>

<form method="post" action="doupdateactions.php">
<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
<table class="pluginlist">
	<tr class="heading">
		<td>Plugin</td>
		<td>Installed</td>
		<td>Latest</td>
		<td class="center">Ask</td>
		<td class="center">Install</td>
		<td class="center">Download Only</td>
		<td class="center">Skip</td>
		<td>Remove</td>
	</tr>
	<?
		$result = db_run(
			'SELECT plugins.*, installed.version AS installed, installed.update_action AS update_action
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
			$action = $row['update_action'];
			$rresult = db_run('SELECT MAX(id) AS latest FROM versions WHERE plugin=?', 's', $plugin);
			$rrow = mysqli_fetch_array($rresult);
			$latest = $rrow['latest'];
		?>
		<tr>
			<td><a href="plugin.php?name=<?=$plugin?>"><?=$dispname?></a></td>
			<td><?=vlink($installed)?></td>
			<td><?=vlink($latest)?></td>
			<td class="center"><input type="radio" name="action[<?=$plugin?>]" value="ask"      <?=($action=='ask'     ?'checked':'')?>></td>
			<td class="center"><input type="radio" name="action[<?=$plugin?>]" value="install"  <?=($action=='install' ?'checked':'')?>></td>
			<td class="center"><input type="radio" name="action[<?=$plugin?>]" value="download" <?=($action=='download'?'checked':'')?>></td>
			<td class="center"><input type="radio" name="action[<?=$plugin?>]" value="skip"     <?=($action=='skip'    ?'checked':'')?>></td>
			<td class="center"><a class="delete" href="doremoveplugin.php?plugin=<?=$plugin?>">X</a></td>
		</tr>
	<? } ?>
</table>
<div style="margin-top: 8px;"><input type="submit" value="Save Preferences"> &nbsp;<a href="updaterhelp.php">What do these options mean?</a></div>
</form>

<? include('footer.php'); ?>
