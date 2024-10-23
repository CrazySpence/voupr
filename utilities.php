<? require('component.php'); ?>
<? require('database.php'); ?>
<? require('session.php'); ?>
<? require('userauth.php'); ?>

<? if (!$utilities) { $utilities = TRUE;
	/////////////////////////////////////////////////////////
	
	function safe ($string)
	{
		global $db;
		return mysqli_real_escape_string($db,$string);
	}
	
	function desafe ($string)
	{
		$string = str_replace('\\\'', '\'', $string);
		$string = str_replace('\\"', '"', $string);
		return $string;
	}
	
	function html ($string)
	{
		$string = desafe($string);
		$string = str_replace('<', '&lt;', $string);
		$string = str_replace('>', '&gt;', $string);
		$string = str_replace("\n", "\n<br>", $string);
		return $string;
	}
	
	function getuserdispname ($username)
	{
		global $db;
		$query = 'SELECT longname FROM users WHERE username="'.$username.'"';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		return $row['longname'];
	}
	
	function getversionid ($plugin, $versionstring)
	{
		global $db;
		$query = 'SELECT id FROM versions WHERE plugin="'.$plugin.'" AND versionstring="'.$versionstring.'"';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		return $row['id'];
	}
	
	function vlink ($id)
	{
		global $db;
		// Get current
		$id = mysqli_real_escape_string($db,$id);
		$query = 'SELECT versionstring, id FROM versions WHERE id="'.$id.'"';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$version = $row['versionstring'];
		$versionid = $id;
		// Get latest
		$query = 'SELECT versionstring, id
				FROM versions WHERE id=
					(SELECT MAX(id) FROM versions WHERE plugin=(SELECT plugin FROM versions WHERE id="'.$id.'"))';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		$latest = $row['versionstring'];
		$latestid = $row['id'];
		// Output
		if ($id == $latestid) { $oldnew = 'newversion'; }
		else { $oldnew = 'oldversion'; }
		$link = '<a class="'.$oldnew.'" href="version.php?id='.$versionid.'">'.$version.'</a>';
		return $link;
	}
	
	function getnumusers ($plugin)
	{
		global $db;
		$query = 'SELECT COUNT(user) AS numusers FROM installed WHERE plugin="'.$plugin.'"';
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		return $row['numusers'];
	}
	
	function getrating ($plugin)
	{
		global $db;
		$query = 'SELECT AVG(rating) AS rating FROM ratings WHERE plugin="'.$plugin.'"';
		$result = mysqli_query($db,$query);
		if ($row = mysqli_fetch_array($result)) {
			return(printrating($row['rating']));
		} else {
			return(printrating(0));
		}
	}
	
	function printrating ($rating)
	{
		if ($rating) { $rating = round($rating/2)*2; }
		else { $rating = 0; }
		$img = '<img src="images/star-'.$rating.'.png" height=12px></img>';
		return $img;
	}
	
	function ismanager ($plugin)
	{
		$yesno = FALSE;
		if ($GLOBALS['user_loggedin'])
		{
			$yesno = userismanager($GLOBALS['user_sname'], $plugin);
		}
		return $yesno;
	}
	
	function userismanager ($user, $plugin)
	{
		global $db;
		$yesno = FALSE;
		$query = 'SELECT username FROM managers WHERE pluginname="'.$plugin.'" AND username="'.$user.'"';
		$result = mysqli_query($db,$query);
		if (mysqli_fetch_array($result)) { $yesno = TRUE; }
		return $yesno;
	}
	
	function pluginexists ($plugin)
	{
		global $db;
		$yesno = TRUE;
		if (strlen($plugin) == 0) { $yesno = FALSE; }
		else
		{
			$query = 'SELECT name FROM plugins WHERE name="'.$plugin.'"';
			$result = mysqli_query($db,$query);
			if (!mysqli_fetch_array($result)) { $yesno = FALSE; }
		}
		return $yesno;
	}
	
	function userexists ($user)
	{
		global $db;
		$yesno = TRUE;
		if (strlen($user) == 0) { $yesno = FALSE; }
		else
		{
			$query = 'SELECT username FROM users WHERE username="'.$user.'"';
			$result = mysqli_query($db,$query);
			if (!mysqli_fetch_array($result)) { $yesno = FALSE; }
		}
		return $yesno;
	}
	
	function error ($error)
	{
		$_SESSION['error'] = $error;
		$redirect_url = 'error.php';
		require('redirect.php');
	}
}?>
