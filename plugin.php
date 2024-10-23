<? require('headerdata.php'); ?>

<? $page_title = TRUE; ?>
<? require('database.php'); ?>
<? require('userauth.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get request data
	$name = mysqli_real_escape_string($db,$_GET['name']);	
	// Check plugin
	if (!pluginexists($name)) { require('404redirect.php'); }
	
	// Set variables
	$query = 'SELECT * FROM plugins WHERE name="'.$name.'"';
	$result = mysqli_query($db,$query);
	$row = mysqli_fetch_array($result);
	$dispname = html($row['longname']);
	$desc = html($row['description']);
	$longdesc = html($row['longdesc']);
	$authors = html($row['authors']);
?>

<? $page_title = $dispname." - VOUPR"; ?>
<? include('header.php'); ?>
	
	<? if (ismanager($name)) {?>
			<div class="editbutton">
				<a href="editplugin.php?plugin=<?=$name?>">Edit</a>
			</div>
	<? } ?>
	
	<SCRIPT LANGUAGE="JavaScript">
	function GoTo (url) { document.location.href = url; }
	
	function Open (url) { window.open(url); }
	
	function ClearStars () {
		star1.src = "images/star-faded.png";
		star2.src = "images/star-faded.png";
		star3.src = "images/star-faded.png";
		star4.src = "images/star-faded.png";
		star5.src = "images/star-faded.png";
	}
	
	function MouseOnStar (num) {
		ClearStars();
		if (num >= 2) { star1.src = "images/star.png"; }
		if (num >= 4) { star2.src = "images/star.png"; }
		if (num >= 6) { star3.src = "images/star.png"; }
		if (num >= 8) { star4.src = "images/star.png"; }
		if (num >= 10) { star5.src = "images/star.png"; }
	}

	function MouseOffStar () {
		ClearStars();
		if (userrating >= 2) { star1.src = "images/star.png"; }
		if (userrating >= 4) { star2.src = "images/star.png"; }
		if (userrating >= 6) { star3.src = "images/star.png"; }
		if (userrating >= 8) { star4.src = "images/star.png"; }
		if (userrating >= 10) { star5.src = "images/star.png"; }
	}
	</SCRIPT>

	<?
		// Get latest version
		$query = 'SELECT
					versionstring,
					id,
					DATE_FORMAT(DATE(timestamp), "%M %D, %Y") AS date
				FROM versions
				WHERE id=(SELECT MAX(id) FROM versions WHERE plugin="'.$name.'")';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$latest = $row['versionstring'];
		$latestid = $row['id'];
		$date = $row['date'];
		
		if ($user_loggedin)
		{
			// Get installed version
			$query = 'SELECT version FROM installed WHERE plugin="'.$name.'" AND user="'.$user_sname.'" LIMIT 1';
			$result = mysqli_query($db,$query);
			if ($row = mysqli_fetch_array($result)) { $installed = $row['version']; }
			// Get user rating
			$query = 'SELECT rating FROM ratings WHERE plugin="'.$name.'" AND user="'.$user_sname.'" LIMIT 1';
			$result = mysqli_query($db,$query);
			if ($row = mysqli_fetch_array($result)) { $myrating = $row['rating']; }
			else { $myrating = 0; }
		}
	?>
	
	<h3><?=$dispname?></h3>
	
	<div class="sidebar floatright">
		<!--Begin Info-->
		<div class="infobox">
			<table class="info">
				<tr>
					<td class="label">Plugin:</td>
					<td class="info"><?=$dispname?></td>
				</tr>
				<tr>
					<td class="label" style="width: 90px;">Latest Version:</td>
					<td class="info">
						<?=vlink($latestid)?> 
						(<a href="downloads/<?=$name?>-<?=$latest?>.zip">Download</a>)
					</td>
				</tr>
				<tr>
					<td class="label">Last Release:</td>
					<td class="info"><?=$date?></td>
				</tr>
				<tr>
					<td class="label">Rating:</td>
					<td class="info"><?=getrating($name)?></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class="label">Installed:</td>
					<td class="info">
						<? if ($installed) { ?>
							<? if ($installed == $latestid) { ?>
								<newversion>You are up-to-date.</newversion>
							<? } else { ?>
								<a class="oldversion" href="doaddplugin.php?plugin=<?=$name?>&version=<?=$latestid?>">Update My Version</a>
							<? } ?>
						<? } else { ?>
								<a href="doaddplugin.php?plugin=<?=$name?>&version=<?=$latestid?>">Add to My Plugins</a>
						<? } ?></td>
				</tr>
				<tr>
					<td class="label">My Rating:</td>
					<td class="info">
						<div class="choosestarbox" OnMouseOut="MouseOffStar()">
							<img id="star1" class="choosestar" src="images/star-faded.png" OnMouseOver="MouseOnStar(2)" OnCLick="GoTo('dorating.php?plugin=<?=$name?>&rating=2')"></img>
							<img id="star2" class="choosestar" src="images/star-faded.png" OnMouseOver="MouseOnStar(4)" OnCLick="GoTo('dorating.php?plugin=<?=$name?>&rating=4')"></img>
							<img id="star3" class="choosestar" src="images/star-faded.png" OnMouseOver="MouseOnStar(6)" OnCLick="GoTo('dorating.php?plugin=<?=$name?>&rating=6')"></img>
							<img id="star4" class="choosestar" src="images/star-faded.png" OnMouseOver="MouseOnStar(8)" OnCLick="GoTo('dorating.php?plugin=<?=$name?>&rating=8')"></img>
							<img id="star5" class="choosestar" src="images/star-faded.png" OnMouseOver="MouseOnStar(10)" OnCLick="GoTo('dorating.php?plugin=<?=$name?>&rating=10')"></img>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<!--End Info-->
	
		<!--Begin Links-->
		<?
			// Check for links
			$query = 'SELECT COUNT(type) AS numlinks FROM links WHERE plugin="'.$name.'"';
			$result = mysqli_query($db,$query);
			$row = mysqli_fetch_array($result);
			if ($row['numlinks'] != 0) { $links = TRUE; }
			// Get links
			$query = 'SELECT * FROM links WHERE plugin="'.$name.'"';
			$result = mysqli_query($db,$query);
		?>
		<? if ($links) { ?>
			<div class="infobox">
				<table class="info">
					<? while ($row = mysqli_fetch_array($result)) { ?>
						<?
							$link = $row['link'];
							$title = $row['title'];
							if ($row['type'] == '0') { $type = 'Website: '; }
							if ($row['type'] == '1') { $type = 'Wiki: '; }
							if ($row['type'] == '2') { $type = 'E-mail: '; $link = 'mailto:'.$link; }
							if ($row['type'] == '3') { $type = 'Thread: '; }
						?>
						<tr>
							<td class="label"><?=$type?></td>
							<td class="info"><a href="<?=$link?>"><?=$title?></a></td>
						</tr>
					<? } ?>
				</table>
			</div>
		<? } ?>
		<!--End Links-->
		<!--Begin Authors-->
		<? if ($authors != '') { ?>
			<div class="creditbox">
				<? if (strpos($authors, ', ') === FALSE) { ?>
					Author: 
				<? } else { ?>
					Authors: 
				<? } ?>
				<?
					$authorcode = '';
					foreach (preg_split('/, /', $authors) as $author)
					{
						$authorcode = $authorcode.', '.'<a class="author" href="authorsearch.php?author='.$author.'">'.$author.'</a>';
					}
					$authorcode = substr($authorcode, 2);
					echo $authorcode;
				?>
			</div>
		<? } ?>
		<!--End Authors-->
	</div>
	
	<div class="main">
		<div class="description"><?=$desc?></div>
		
		<!--Begin Details-->
		<? if ($longdesc != '') { ?>
			<div class="longdesc">
				<?=$longdesc?>
			</div>
		<? } ?>
		<!--End Details-->
		
		<!--Begin Screenshots-->
		<?
			$screenshots = array();
			$dispscreenshots = FALSE;
			for ($i=1; $i<=3; $i++)
			{
				$screenshots[$i] = 'screenshots/'.$name.'-'.$i.'.png';
				if (file_exists($screenshots[$i])) { $dispscreenshots = TRUE; }
			}
		?>
		<? if ($dispscreenshots) { ?>
			<div class="screenshots">
				<? for ($i=1; $i<=count($screenshots); $i++) { ?>
					<? if (file_exists($screenshots[$i])) { ?>
						<img class="thumbnail" src="<?=$screenshots[$i]?>" OnClick="Open('<?=$screenshots[$i]?>')"></img>
					<? } ?>
				<? } ?>
			</div>
		<? } ?>
		<!--End Screenshots-->
		
		<table class="versionlist">
			<tr class="heading">
				<td>Version</td>
				<td>Release Date</td>
				<td>Download</td>
				<td>My Plugins</td>
			</tr>
			<?
				// Get version table info
				$query = 'SELECT id, versionstring, DATE_FORMAT(DATE(timestamp), "%Y - %b %d") AS date, description FROM versions WHERE plugin="'.$name.'" ORDER BY id DESC';
				$result = mysqli_query($db,$query);
				$oldnew = 'newversion';
			?>
			<? while($row = mysqli_fetch_array($result)) { ?>
				<?
					$versionid = $row['id'];
					$version = $row['versionstring'];
					$date = $row['date'];
				?>
				<tr>
					<td><a class="<?=$oldnew?>" href="version.php?id=<?=$versionid?>"><?=$version?></a></td>
					<td><?=$date?></td>
					<td><a href="downloads/<?=$name?>-<?=$version?>.zip">Download</a></td>
					<td>
						<? if ($installed == $versionid) { ?>
							<<?=$oldnew?>>Installed</<?=$oldnew?>>
						<? } else { ?>
							<a class="<?=$oldnew?>" href="doaddplugin.php?plugin=<?=$name?>&version=<?=$versionid?>">Use this version</a>
						<? } ?>
					</td>
				</tr>
				<? $oldnew = 'oldversion'; ?>
			<? } ?>
		</table>
	</div>
	
	<SCRIPT LANGUAGE="JavaScript">
	var star1 = document.getElementById("star1");
	var star2 = document.getElementById("star2");
	var star3 = document.getElementById("star3");
	var star4 = document.getElementById("star4");
	var star5 = document.getElementById("star5");
	
	var userrating = <?=$myrating?>;
	
	MouseOffStar();
	</SCRIPT>

<? include('footer.php'); ?>
