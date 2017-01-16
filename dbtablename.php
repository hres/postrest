<?php

$config = parse_ini_file('./db.ini');
	//connection to the Server
	$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");


if ($dbhandle->connect_error) {
    die("Connection failed: " . $dbhandle->connect_error);
} 
echo "Connected successfully1<br /><br />";

function get_active_db(){

    $sql='SELECT DATABASE()';

    $sqlresult=mysql_query($sql);

    $row=mysql_fetch_row($sqlresult);

    $active_db=$row[0];

    echo "Active Database :<b> $active_db</b> ";

    }

?>
