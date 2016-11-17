<?php
$config1 = parse_ini_file('./db.ini');
$dbhandle1 = mysqli_connect($config1['hostname'], $config1['username'], $config1['password'],$config1['dbname']) or die("Unable to connect to Server");
$choice = mysql_real_escape_string($_GET['choice']);
$choice2 = $_SERVER['QUERY_STRING']
echo "<H1>$choice</H1>";
echo "<H1>$choice2</H1>";

$querysubcategories_prepare1 = mysqli_stmt_init($dbhandle1);
	mysqli_stmt_prepare($querysubcategories_prepare1, "SELECT * FROM `SubCategories` WHERE CategoryID='$choice'");
	mysqli_stmt_execute($querysubcategories_prepare1);
	mysqli_stmt_bind_result($querysubcategories_prepare1,$col11,$col12,$col13,$col14,$col15,$col16,$col17,$col18,$col19,$col20);
//insert an if statement here for french
//if english then col2 if french then col3  
	
	while(mysqli_stmt_fetch($querysubcategories_prepare1)){
	  echo "<option value=$col11>$col13 ($col12)</option>";
	}
/*
$query = "SELECT * FROM `SubCategories` WHERE CategoryID='$choice'";
	
	$results = $dbhandle->query($query);
	mysqli_stmt_bind_result($results,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);
	while(mysqli_stmt_fetch($results)){
		  echo "<option value=$col1>$col3 ($col2)</option>";
	}

*/
	mysqli_close($dbhandle1);
?>
