<?php
$config = parse_ini_file('./db.ini');
$host=$config['hostname'];
$username=$config['username'];
$password=$config['password'];
$databasename=$config['dbname'];
$connect=mysql_connect($host,$username,$password);
$db=mysql_select_db($databasename);

//Connect and select the database
$db = new mysqli($host, $username, $password, $databasename);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>
