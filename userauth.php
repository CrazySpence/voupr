<?
	require('component.php');
	require('database.php');
	require('session.php');

	if (!$userauth) { $userauth = TRUE;
		/////////////////////////////////////
	
		function user_login ($username)
		{
			$_SESSION['user_name'] = $username;
			$GLOBALS['user_name'] = $username;
			$GLOBALS['user_sname'] = $username;
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
			if (isset($_COOKIE['remember_token'])) {
				db_run('UPDATE users SET remember_token=NULL WHERE remember_token=?', 's', $_COOKIE['remember_token']);
				setcookie('remember_token', '', time()-60*60*24*365);
			}
			// Clear old-style cookies for any browsers that still have them
			setcookie('username', '', time()-60*60*24*365);
			setcookie('password', '', time()-60*60*24*365);
		}

		function check_login_cookie ()
		{
			if (isset($_COOKIE['remember_token'])) {
				$token = $_COOKIE['remember_token'];
				$result = db_run('SELECT username FROM users WHERE remember_token=?', 's', $token);
				if ($row = mysqli_fetch_array($result)) {
					user_login($row['username']);
				}
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
					$token = bin2hex(random_bytes(32));
					db_run('UPDATE users SET remember_token=? WHERE username=?', 'ss', $token, $username);
					global $full_path, $full_server;
					setcookie('remember_token', $token, time()+60*60*24*365, $full_path, $full_server);
				}
			}
			else { $error = TRUE; }
			return $error;
		}

		function password_match ($username, $password)
		{
			$result = db_run('SELECT password FROM users WHERE username=?', 's', $username);
			$row = mysqli_fetch_array($result);
			if (!$row) { return FALSE; }
			$stored = $row['password'];

			// Legacy MD5 hash: 32 hex chars
			if (strlen($stored) === 32 && ctype_xdigit($stored)) {
				if (md5($password) !== $stored) { return FALSE; }
				// Upgrade to bcrypt transparently on successful login
				db_run('UPDATE users SET password=? WHERE username=?', 'ss',
					password_hash($password, PASSWORD_DEFAULT), $username);
				return TRUE;
			}

			// Modern bcrypt hash
			return password_verify($password, $stored);
		}
	
		// Check login
		if (isset($_SESSION['user_name']))
			{ user_login($_SESSION['user_name']); }
		else
			{ user_logout(); check_login_cookie(); }
	}
?>
