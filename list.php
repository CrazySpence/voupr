<? require('headerdata.php'); ?>

<? $page_title = "Plugin List - VOUPR";?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get sort data
	$sort = 'longname ASC';
	if ($_GET['sort'] == 'name') { $sort = 'longname ASC'; }
	if ($_GET['sort'] == 'rating') { $sort = 'rating DESC'; }
	if ($_GET['sort'] == 'users') { $sort = 'users DESC'; }
?>

<? include('header.php'); ?>

<h3>Plugin List</h3>

<table class="pluginlist">
	<tr class="heading">
		<td><a class="sort" href="list.php">Plugin</a></td>
		<td><a class="sort" href="list.php?sort=rating">Rating</a></td>
		<td><a class="sort" href="list.php?sort=users">Users</a></td>
		<td>Description</td>
	</tr>
	<?
		require('pluginlist.php');
	?>
	<? while($row = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><a href="plugin.php?name=<?=$row['name']?>"><?=desafe($row['longname'])?></a></td>
			<td><?=printrating($row['rating'])?></td>
			<td class="number"><?=$row['users']?></td>
			<td><?=desafe($row['description'])?></td>
		</tr>
	<? } ?>
</table>

<? include('footer.php'); ?>
