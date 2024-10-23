<?
    include('component.php');

    if (!$mysql) { $mysql = TRUE;
	    /////////////////////////////////////
	
	    $mysql_host = 'localhost';
	    $mysql_database = 'vouprtest';
	    $mysql_user = 'vouprtest';
	    $mysql_password = 'vouprtest!';

	    $db = mysqli_connect($mysql_host, $mysql_user, $mysql_password,$mysql_database);
	    $mysql_init = TRUE;
    }
?>
