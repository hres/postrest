<?php
$host="localhost";
$username="root";
$password="123456";
$databasename="acceptedlist";
$connect=mysql_connect($host,$username,$password);
$db=mysql_select_db($databasename);

//Connect and select the database
$db = new mysqli($host, $username, $password, $databasename);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}



?>
