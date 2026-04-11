<?
	$page_title = TRUE;
	require('database.php');

	header('Content-Type: application/json');

	// Token auth — no session
	$token = $_POST['token'] ?? '';
	if (strlen($token) !== 64 || !ctype_xdigit($token)) {
		http_response_code(401);
		echo json_encode(['error' => 'Invalid token']);
		exit();
	}

	$result = db_run('SELECT username FROM users WHERE api_token=?', 's', $token);
	$row = mysqli_fetch_array($result);
	if (!$row) {
		http_response_code(401);
		echo json_encode(['error' => 'Invalid token']);
		exit();
	}
	$username = $row['username'];

	$plugin  = $_POST['plugin'] ?? '';
	$version = intval($_POST['version']);

	// Validate plugin exists
	if (!$plugin) {
		http_response_code(400);
		echo json_encode(['error' => 'Missing plugin']);
		exit();
	}
	$r = db_run('SELECT name FROM plugins WHERE name=? LIMIT 1', 's', $plugin);
	if (!mysqli_fetch_array($r)) {
		http_response_code(400);
		echo json_encode(['error' => 'Plugin not found']);
		exit();
	}

	// Validate version belongs to this plugin
	$r = db_run('SELECT id FROM versions WHERE plugin=? AND id=? LIMIT 1', 'si', $plugin, $version);
	if (!mysqli_fetch_array($r)) {
		http_response_code(400);
		echo json_encode(['error' => 'Version not found']);
		exit();
	}

	// Upsert installed record (same logic as doaddplugin.php)
	$r = db_run('SELECT version FROM installed WHERE user=? AND plugin=?', 'ss', $username, $plugin);
	if (mysqli_fetch_array($r)) {
		db_run('UPDATE installed SET version=? WHERE user=? AND plugin=?', 'iss', $version, $username, $plugin);
	} else {
		db_run('INSERT INTO installed (user, plugin, version) VALUES (?, ?, ?)', 'ssi', $username, $plugin, $version);
	}

	echo json_encode(['ok' => true]);
	exit();
?>
