<?
	$page_title = TRUE;
	require('../database.php');

	header('Content-Type: application/json');

	$token = $_GET['token'] ?? '';
	if (strlen($token) !== 64 || !ctype_xdigit($token)) {
		http_response_code(401);
		echo json_encode(['error' => 'Missing or invalid token']);
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

	$base_url = 'https://' . $_SERVER['SERVER_NAME'];

	$result = db_run(
		'SELECT
			plugins.name AS plugin,
			plugins.longname AS dispname,
			iv.versionstring AS installed_version,
			installed.version AS installed_id,
			installed.update_action AS update_action,
			lv.id AS latest_id,
			lv.versionstring AS latest_version
		 FROM installed
		 JOIN plugins ON plugins.name = installed.plugin
		 JOIN versions AS iv ON iv.id = installed.version
		 JOIN versions AS lv ON lv.id = (
			 SELECT MAX(id) FROM versions WHERE plugin = installed.plugin
		 )
		 WHERE installed.user = ?',
		's', $username
	);

	$plugins = [];
	while ($row = mysqli_fetch_array($result)) {
		$pname   = $row['plugin'];
		$latestv = $row['latest_version'];
		$plugins[] = [
			'plugin'            => $pname,
			'dispname'          => $row['dispname'],
			'installed_version' => $row['installed_version'],
			'installed_id'      => intval($row['installed_id']),
			'update_action'     => $row['update_action'],
			'latest_version'    => $latestv,
			'latest_id'         => intval($row['latest_id']),
			'update_available'  => intval($row['installed_id']) < intval($row['latest_id']),
			'download_url'      => $base_url . '/downloads/' . rawurlencode($pname) . '-' . rawurlencode($latestv) . '.zip',
		];
	}

	echo json_encode(['plugins' => $plugins], JSON_PRETTY_PRINT);
	exit();
?>
