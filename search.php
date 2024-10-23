<? require('headerdata.php'); ?>

<? $page_title = "Plugin Search - VOUPR";?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get search and sort
	$search = mysqli_real_escape_string($db,$_GET['search']);
	$sort = 'longname ASC';
	if ($_GET['sort'] == 'name') { $sort = 'longname ASC'; }
	if ($_GET['sort'] == 'rating') { $sort = 'rating DESC'; }
	if ($_GET['sort'] == 'users') { $sort = 'users DESC'; }
	
	// Get results
	$terms = explode(' ', $search);
	$condition = '';
	foreach ($terms as $term)
	{
		$condition = $condition.' AND (longname LIKE "%'.$term.'%" OR description LIKE "%'.$term.'%")';
	}
	require('pluginlist.php');
?>

<? include('header.php'); ?>

	<h3>Search</h3>

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
