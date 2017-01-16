<?php

$config = parse_ini_file('./db.ini');
	//connection to the Server
	$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");


$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);

?>
