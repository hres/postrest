<a href="http://www.inspection.gc.ca/active/scripts/fssa/reference/reference.asp?lang=e"> Link </a>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php 
//replacement for include
$config = parse_ini_file('./db.ini');
//connection to the Server
$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");
// Create dropdown for Categories
	//<p> To view the list of companies and their products, please select a category and a sub-category. </p>
echo "Category: <select name='searchcategories'>";
	$querycategories_prepare = mysqli_stmt_init($dbhandle);
	mysqli_stmt_prepare($querycategories_prepare, "SELECT * FROM `Categories`;");
	mysqli_stmt_execute($querycategories_prepare);
	mysqli_stmt_bind_result($querycategories_prepare,$col1,$col2,$col3,$col4,$col5,$col6);
//insert an if statement here for french
//if english then col2 if french then col3  
	
		while(mysqli_stmt_fetch($querycategories_prepare)){
        	  echo "<option value=$col1>$col2</option>";
		}
	echo "</select>";
echo "Sub-Category: <select name='searchsubcategories'>";
	$querysubcategories_prepare = mysqli_stmt_init($dbhandle);
	mysqli_stmt_prepare($querysubcategories_prepare, "SELECT * FROM `SubCategories`;");
	mysqli_stmt_execute($querysubcategories_prepare);
	mysqli_stmt_bind_result($querysubcategories_prepare,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);
//insert an if statement here for french
//if english then col2 if french then col3  
	
		while(mysqli_stmt_fetch($querysubcategories_prepare)){
        	  echo "<option value=$col1>$col3 ($col2)</option>";
		}
	echo "</select>";
mysqli_close($dbhandle); //close the connection
?>
</table>
