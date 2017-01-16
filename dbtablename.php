<?php

$config = parse_ini_file('./db.ini');
	//connection to the Server
	$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");


if ($dbhandle->connect_error) {
    die("Connection failed: " . $dbhandle->connect_error);
} 
echo "Connected successfully<br /><br />";
?>
