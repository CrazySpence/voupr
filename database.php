<?
    include('component.php');
    include('../secrets.inc');
    if (!$mysql) { $mysql = TRUE;
	    /////////////////////////////////////
	
	    $db = mysqli_connect($mysql_host, $mysql_user, $mysql_password,$mysql_database);
	    $mysql_init = TRUE;

	    function db_run(string $sql, string $types = '', ...$params): mysqli_result|bool {
	        global $db;
	        $stmt = mysqli_prepare($db, $sql);
	        if ($types !== '') {
	            mysqli_stmt_bind_param($stmt, $types, ...$params);
	        }
	        mysqli_stmt_execute($stmt);
	        return mysqli_stmt_get_result($stmt);
	    }
    }
?>
