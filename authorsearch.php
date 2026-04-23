<? require('headerdata.php'); ?>

<?
	// Get search and sort
	$author = $_GET['author'];
	$sort = 'longname ASC';
	if ($_GET['sort'] == 'name') { $sort = 'longname ASC'; }
	if ($_GET['sort'] == 'rating') { $sort = 'rating DESC'; }
	if ($_GET['sort'] == 'users') { $sort = 'users DESC'; }

	// Import modules
	$page_title = $author.'\'s Plugins';
	require('database.php');
	require('utilities.php');

	// Build parameterized author condition
	$condition_sql = ' AND (authors LIKE ?)';
	$condition_params = ['%' . $author . '%'];
	$condition_types = 's';
	require('pluginlist.php');
?>

<? include('header.php'); ?>

	<h3><?=$author?>'s Plugins</h3>

	<table class="pluginlist">
		<tr class="heading">
			<td><a class="sort" href="search.php?search=<?=$search?>">Plugin</a></td>
			<td><a class="sort" href="search.php?search=<?=$search?>&sort=rating">Rating</td>
			<td><a class="sort" href="search.php?search=<?=$search?>&sort=users">Users</td>
			<td>Description</td>
		</tr>
		
		<? while($row = mysqli_fetch_array($result)) { ?>
			<tr>
				<td><a href="plugin.php?name=<?=$row['name']?>"><?=desafe($row['longname'])?></a></td>
				<td><?=printrating($row['rating'])?></td>
				<td class="number"><?=getnumusers($row['name'])?></td>
				<td><?=desafe($row['description'])?></td>
			</tr>
		<? } ?>
	</table>

<? include('footer.php'); ?>
