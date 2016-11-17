<?php
$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");
$choice = mysql_real_escape_string($_GET['choice']);
$query = "SELECT * FROM `SubCategories` WHERE CategoryID='$choice'";
	
	$results = $dbhandle->query($query);
	mysqli_stmt_bind_result($results,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);
	while(mysqli_stmt_fetch($results)){
		  echo "<option value=$col1>$col3 ($col2)</option>";
	}
?>
