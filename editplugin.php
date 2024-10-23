<? require('headerdata.php'); ?>

<? $page_title = "Edit Plugin - VOUPR"; ?>
<? require('database.php'); ?>
<? require('session.php'); ?>
<? require('utilities.php'); ?>

<?
	// Get request data
	$plugin = mysqli_real_escape_string($db,$_GET['plugin']);
	$query = 'SELECT * FROM plugins WHERE name="'.$plugin.'"';
	$result = mysqli_query($db,$query);
	if (!$row = mysqli_fetch_array($result)) { 
		require('404redirect.php');
	} else {
		$dispname = desafe($row['longname']);
		$description = desafe($row['description']);
		$longdesc = desafe($row['longdesc']);
		$authors = desafe($row['authors']);
	}
	
	// Require login
	$post_login = 'editplugin.php?plugin='.$plugin;
	require('loggedin.php');
	
	// Check authorization
	if (!ismanager($plugin)) { error('You do not have permission to perform this operation'); }
	
	// Load form data
	if ($_SESSION['editplugin_dispname']) { $dispname = $_SESSION['editplugin_dispname']; }
	if ($_SESSION['editplugin_dispname']) { $description = $_SESSION['editplugin_description']; }
	unset($_SESSION['editplugin_dispname']);
	unset($_SESSION['editplugin_description']);
?>

<? include('header.php'); ?>
	
	<script language="JavaScript">
		function Open (url) { window.open(url); }
	
		function AddManagerForm () {
			document.getElementById("addmanagerform").style.display = 'inline';
			showform = true;
		}
		
		function AddManagerButton () {
			document.getElementById("addmanagerform").style.display = 'none';
			showform = false;
		}
		
		var showform = true;
		function AddManagerToggle () {
			if (showform) { AddManagerButton(); }
			else { AddManagerForm(); }
		}
	</script>
	
	<div class="editbutton">
		<a href="plugin.php?name=<?=$plugin?>">Back</a>
	</div>

	<h3><?=$dispname?></h3>
	
	<div class="col floatleft">
		<!--Begin Detailed-->
		<div class="infobox">
			<b>Default keys & commands:</b>
			<form class="contained" name="details" method="post" action="dodetail.php">
				<textarea name="longdesc" class="fullwidth" rows=10><?=$longdesc?></textarea>
				<input type="hidden" name="plugin" value="<?=$plugin?>">
				<input type="submit">
			</form>
		</div>
		<!--End Detailed-->
		
		<!--Begin Screenshots-->
		<div class="infobox">
			<b>Screenshots</b>
			<form class="contained" name="screenshots" method="post" action="doscreenshots.php" enctype="multipart/form-data">
				<? for ($i = 1; $i<=3; $i++) { ?>
					<!--Begin Screenshot <?=$i?>-->
					<? $filepath = 'screenshots/'.$plugin.'-'.$i.'.png'; ?>
					<? if (file_exists($filepath)) { ?>
						<div class="picbox">
							<img class="thumbnail" src="<?=$filepath?>" OnClick="Open('<?=$filepath?>')"></img>
							<a class="delete" href="doremovescreenshot.php?plugin=<?=$plugin?>&number=<?=$i?>">X</a>
						</div>
					<? } else { ?>
						<!--<div class="picbox"><img class="thumbnail" src="images/empty.png"></img></div>-->
					<? } ?>
					<? if ($_GET['badfile'.$i]) { ?>
						<div class="pluginerror">
							Error uploading file.
						</div>
					<? } ?>
					<? if ($_GET['bigfile'.$i]) { ?>
						<div class="pluginerror">
							Picture exceeds 1MB.
						</div>
					<? } ?>
					<? if ($_GET['badfiletype'.$i]) { ?>
						<div class="pluginerror">
							You may only upload PNG images.
						</div>
					<? } ?>
					<input type="file" name="screenshot<?=$i?>" id="screenshot<?=$i?>">
					<!--End Screenshot <?=$i?>-->
				<? } ?>
				<input type="hidden" name="plugin" value="<?=$plugin?>">
				<div class="submit"><input type="submit"></div>
			</form>
		</div>
		<!--End Screenshots-->
	</div>

	<div class="col floatright" style="width: 330px">
		<!--Begin Info-->
		<div class="infobox floatright">
			<? if ($_GET['baddispname']) { ?>
				<div class="pluginerror">
					Please choose a different display name.
				</div>
			<? } ?>
			<form name="newplugin" method="post" action="doeditplugin.php" enctype="multipart/form-data">
				<table class="input">
					<tr>
						<td class="label">Plugin ID:</td>
						<td class="input"><a href="plugin.php?name=<?=$plugin?>"><?=$plugin?></a></td>
					</tr>
					<tr>
						<td class="label">Display Name:</td>
						<td class="input"><input type="text" name="displayname" value="<?=$dispname?>"></td>
					</tr>
					<tr>
						<td class="label">Description:</td>
						<td class="input"><textarea name="description" ><?=$description?></textarea></td>
					</tr>
					<tr>
						<input type="hidden" name="plugin" value="<?=$plugin?>">
						<td class="submit" colspan=2><input type="submit"></td>
					</tr>
				</table>
			</form>
		</div>
		<!--End Info-->

		<!--Begin Links-->
		<script language="JavaScript">
			function AddLinkShow () {
				document.getElementById("addlinkform").style.display = 'inline';
				showaddlink = true;
			}
		
			function AddLinkHide () {
				document.getElementById("addlinkform").style.display = 'none';
				showaddlink = false;
			}
		
			var showaddlink = true;
			function AddLinkToggle () {
				if (showaddlink) { AddLinkHide(); }
				else { AddLinkShow(); }
			}
		</script>
	
		<div class="infobox" style="clear: both">
			<b>Links</b>
				(<img src="images/plus-16x16.png" class="plusicon" OnClick="AddLinkToggle()"></img>)
			<ul>
				<div class="inline" id="addlinkform">
					<li>
						<form class="inline" name="addlink" method="post" action="doaddlink.php">
							<table class="addlink">
								<tr>
									<td class="label">Type:</td>
									<td class="input"><select name="type">
										<option value="0"> Website
										<option value="1"> Wiki
										<option value="2"> Email
										<option value="3"> Thread
									</select></td>
								</tr>
								<tr>
									<td class="label">Title:</td>
									<td class="input"><input type="text" name="title"></td>
								</tr>
								<tr>
									<td class="label">Link:</td>
									<td class="input">
										<input type="text" name="link">
										<input type="hidden" name="plugin" value="<?=$plugin?>">
										<input type="image" src="images/plus-16x16.png" style="width: 16px; border: none; position: relative; top: 4px;">
									</td>
								</tr>
							</table>
						</form>
					</li>
				</div>
				<script language="JavaScript">
					AddLinkHide();
				</script>
				<?
					$query = 'SELECT * FROM links WHERE plugin="'.$plugin.'" ORDER BY title ASC';
					$result = mysqli_query($db,$query);
					while ($row = mysqli_fetch_array($result))
					{
						$link = $row['link'];
						$title = $row['title'];
						if ($row['type'] == '0') { $type = 'Website: '; }
						if ($row['type'] == '1') { $type = 'Wiki: '; }
						if ($row['type'] == '2') { $type = 'E-mail: '; $link = 'mailto:'.$link; }
						if ($row['type'] == '3') { $type = 'Thread: '; }
						echo '<li>'.$type.'<a href="'.$link.'">'.$title.'</a>';
						echo ' (<a class="delete" href="doremovelink.php?id='.$row['id'].'">X</a>)';
					}
				?>
			</ul>
		</div>
		<!--End Links-->

		<!--Begin Managers-->
		<div class="infobox">
			<b>Managers</b>
				(
					<div class="inline" id="addmanagerbutton">
						<a href="javascript:AddManagerToggle()">add</a>
					</div>
					<div class="inline" id="addmanagerform">:
						<form class="inline" name="addmanager" method="post" action="doaddmanager.php">
							<input type="text" name="newmanager" class="username">
							<input type="hidden" name="plugin" value="<?=$plugin?>">
							<input type="image" src="images/plus-16x16.png" style="border: none; position: relative; top: 4px;">
						</form>
					</div>
					<script language="JavaScript">
						AddManagerButton();
					</script>
				)
			<? if ($_GET['dupmanager']) { ?>
				<div class="pluginerror">
					User is already a manager.
				</div>
			<? } ?>
			<? if ($_GET['badusername']) { ?>
				<div class="pluginerror">
					User does not exist.
				</div>
			<? } ?>
			<? if ($_GET['lastmanager']) { ?>
				<div class="pluginerror">
					You cannot remove the last manager.
				</div>
			<? } ?>
			<ul>
				<?
					$query = 'SELECT username FROM managers WHERE pluginname="'.$plugin.'" ORDER BY username ASC';
					$result = mysqli_query($db,$query);
					while ($row = mysqli_fetch_array($result))
					{
						echo '<li>'.$row['username'];
						echo ' (<a class="delete" href="doremovemanager.php?plugin='.$plugin.'&user='.$row['username'].'">X</a>)';
					}
				?>
			</ul>
		</div>
		<!--End Managers-->
		
		<!--Begin Authors-->
		<div class="infobox">
			<b>Authors:</b>
			<form class="contained" name="authors" method="post" action="doauthors.php">
				<input name="authors" class="fullwidth" rows=10 value="<?=$authors?>">
				<input type="hidden" name="plugin" value="<?=$plugin?>">
				<input type="submit">
			</form>
		</div>
		<!--End Authors-->
	</div>

<? include('footer.php'); ?>
