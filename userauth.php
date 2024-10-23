<?
	require('component.php');
	require('database.php');
	require('session.php');

	if (!$userauth) { $userauth = TRUE;
		/////////////////////////////////////
	
		function user_login ($username)
		{
			global $db;
			$_SESSION['user_name'] = $username;
			$GLOBALS['user_name'] = $username;
			$GLOBALS['user_sname'] = mysqli_real_escape_string($db,$username);
			$GLOBALS['user_loggedin'] = TRUE;
		}
	
		function user_logout ()
		{
			global $db;
			// Clean session
			unset($_SESSION['user_name']);
			unset($GLOBALS['user_name']);
			unset($GLOBALS['user_sname']);
			$GLOBALS['user_loggedin'] = FALSE;
		}
		
		function delete_cookies ()
		{
			// Delete cookies
			setcookie('username', '', time()-60*60*24*365);
			setcookie('password', '', time()-60*60*24*365);
		}
	
		function check_login_cookie ()
		{
			if (isset($_COOKIE['username']) and isset($_COOKIE['password']))
			{
				check_login($_COOKIE['username'], $_COOKIE['password'], false);
			}
		}
	
		function check_login ($username, $password, $remember)
		{
			if (password_match($username, $password))
			{
				// Sign in
				user_login($username);
				if ($remember)
				{
					setcookie('username', $username, time()+60*60*24*365, $full_path, $full_sever);
					setcookie('password', $password, time()+60*60*24*365, $full_path, $full_server);
				}
			}
			else { $error = TRUE; }
			return $error;
		}
	
		function password_match ($username, $password)
		{
			global $db;
			$query = 'SELECT * FROM users WHERE username="'.$username.'" AND password="'.$password.'"';
			$result = mysqli_query($db,$query);
			if (mysqli_fetch_array($result)) { return TRUE; }
			else { return FALSE; }
		}
	
		// Check login
		if (isset($_SESSION['user_name']))
			{ user_login($_SESSION['user_name']); }
		else
			{ user_logout(); check_login_cookie(); }
	}
?>
