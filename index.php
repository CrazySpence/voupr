<?php require('headerdata.php'); ?>

<?php $page_title = "VO Unofficial Plugin Repository";?>
<?php include('header.php'); ?>
<?php require('database.php'); ?>
<?php require('utilities.php'); ?>

<?php
	$news = $_GET['news'];
	if (!$news) { $news = 15; }
?>

<h4>Welcome to the Vendetta-Online Unofficial Plugin Repository (VOUPR)</h4>
VOUPR provides a central location for plugin maintainers to post and distribute their software.  Users may then download, rate and mark plugins to be notified when updates are released.  Most importantly, VOUPR standardizes plugin information and versions in a machine-readable format allowing for the creation of auto-updaters and plugin syncing.<br><br>

For a complete list of hosted plugins, see the main <a href="list.php">plugin list</a>.<br><br>

For installation instructions, see the <a href="http://www.vendetta-online.com/x/msgboard/9/17439">forum thread</a>.

<div class="warning">
	DISCLAIMER: This site and the content on it is in no way associated with or endorsed by Vendetta-Online&trade or Guild Software.
</div>

<h3>Recent Updates</h3>
<table class="newstable">
<?php
	$query = 'SELECT id, DATE_FORMAT(timestamp, "%b %e") as date, plugin, longname
		FROM versions, plugins
		WHERE plugin=name
		ORDER BY id DESC
		LIMIT '.$news;
	// AND timestamp > SUBDATE(CURDATE(), INTERVAL 14 DAY)
	$result = mysqli_query($db,$query);
	while ($row = mysqli_fetch_array($result))
	{
	?>
		<tr>
			<td class="timestamp"><?=$row['date']?></td>
			<td><a href="plugin.php?name=<?=$row['plugin']?>"><?=desafe($row['longname'])?></a> uploaded version <?=vlink($row['id'])?></td>
		</tr>
	<?php
	}
?>
	<tr><td></td></tr>
	<tr>
	<td></td>
	<td><a href="index.php?news=<?=$news+15?>">Older items...</a></td>
	</tr>
</table>

<?php include('footer.php'); ?>
