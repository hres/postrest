<?php
$config = parse_ini_file('./db.ini');
$dbhandle1 = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");
$choice = mysql_real_escape_string($_GET['choice']);
$choice2 = $_SERVER['QUERY_STRING']
echo "<H1>$choice</H1>";
echo "<H1>$choice2</H1>";

$querysubcategories_prepare = mysqli_stmt_init($dbhandle1);
	mysqli_stmt_prepare($querysubcategories_prepare, "SELECT * FROM `SubCategories` WHERE CategoryID='$choice'");
	mysqli_stmt_execute($querysubcategories_prepare);
	mysqli_stmt_bind_result($querysubcategories_prepare,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);
//insert an if statement here for french
//if english then col2 if french then col3  
	
	while(mysqli_stmt_fetch($querysubcategories_prepare)){
	  echo "<option value=$col1>$col3 ($col2)</option>";
	}
<!--
$query = "SELECT * FROM `SubCategories` WHERE CategoryID='$choice'";
	
	$results = $dbhandle->query($query);
	mysqli_stmt_bind_result($results,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);
	while(mysqli_stmt_fetch($results)){
		  echo "<option value=$col1>$col3 ($col2)</option>";
	}

-->
	mysqli_close($dbhandle1);
?>
