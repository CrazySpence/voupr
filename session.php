<?
	require('component.php');

	if (!$session) { $session = TRUE;
		/////////////////////////////////////

		session_start();

		if (empty($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}

		function csrf_verify() {
			$token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
			if (!$token || !hash_equals($_SESSION['csrf_token'], $token)) {
				http_response_code(403);
				die('Invalid CSRF token.');
			}
		}
	}
?>
