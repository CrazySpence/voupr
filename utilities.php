<? require('component.php'); ?>
<? require('database.php'); ?>
<? require('session.php'); ?>
<? require('userauth.php'); ?>

<? if (!$utilities) { $utilities = TRUE;
	/////////////////////////////////////////////////////////
	
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
		$result = db_run('SELECT longname FROM users WHERE username=?', 's', $username);
		$row = mysqli_fetch_array($result);
		return $row['longname'];
	}

	function getversionid ($plugin, $versionstring)
	{
		$result = db_run('SELECT id FROM versions WHERE plugin=? AND versionstring=?', 'ss', $plugin, $versionstring);
		$row = mysqli_fetch_array($result);
		return $row['id'];
	}

	function vlink ($id)
	{
		$id = intval($id);
		// Get current
		$result = db_run('SELECT versionstring, id FROM versions WHERE id=?', 'i', $id);
		$row = mysqli_fetch_array($result);
		$version = $row['versionstring'];
		$versionid = $id;
		// Get latest
		$result = db_run(
			'SELECT versionstring, id FROM versions WHERE id=(SELECT MAX(id) FROM versions WHERE plugin=(SELECT plugin FROM versions WHERE id=?))',
			'i', $id
		);
		$row = mysqli_fetch_array($result);
		$latestid = $row['id'];
		// Output
		$oldnew = ($id == $latestid) ? 'newversion' : 'oldversion';
		return '<a class="'.$oldnew.'" href="version.php?id='.$versionid.'">'.$version.'</a>';
	}

	function getnumusers ($plugin)
	{
		$result = db_run('SELECT COUNT(user) AS numusers FROM installed WHERE plugin=?', 's', $plugin);
		$row = mysqli_fetch_array($result);
		return $row['numusers'];
	}

	function getrating ($plugin)
	{
		$result = db_run('SELECT AVG(rating) AS rating FROM ratings WHERE plugin=?', 's', $plugin);
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
		$result = db_run('SELECT username FROM managers WHERE pluginname=? AND username=?', 'ss', $plugin, $user);
		return (bool) mysqli_fetch_array($result);
	}

	function pluginexists ($plugin)
	{
		if (strlen($plugin) == 0) { return FALSE; }
		$result = db_run('SELECT name FROM plugins WHERE name=?', 's', $plugin);
		return (bool) mysqli_fetch_array($result);
	}

	function userexists ($user)
	{
		if (strlen($user) == 0) { return FALSE; }
		$result = db_run('SELECT username FROM users WHERE username=?', 's', $user);
		return (bool) mysqli_fetch_array($result);
	}
	
	function error ($error)
	{
		$_SESSION['error'] = $error;
		$redirect_url = 'error.php';
		require('redirect.php');
	}
}?>
