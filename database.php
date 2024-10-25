<?
    include('component.php');
    include('../secrets.inc');
    if (!$mysql) { $mysql = TRUE;
	    /////////////////////////////////////
	
	    $db = mysqli_connect($mysql_host, $mysql_user, $mysql_password,$mysql_database);
	    $mysql_init = TRUE;
    }
?>
