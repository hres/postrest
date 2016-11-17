<a href="http://www.inspection.gc.ca/active/scripts/fssa/reference/reference.asp?lang=e"> Link </a>
<a href="http://www.codexworld.com/dynamic-dependent-select-box-using-jquery-ajax-php/"> jquery</a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#searchcategories").change(function()
		{
			$("#searchsubcategories").load("subcategories.php?choice=" + $("#searchcategories").value);
		});
	});
</script>
<?php
	//replacement for include
	$config = parse_ini_file('./db.ini');
	//connection to the Server
	$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	Category: 
	<select name="searchcategories" id="searchcategories">
	<?php
		$querycategories_prepare = mysqli_stmt_init($dbhandle);
		mysqli_stmt_prepare($querycategories_prepare, "SELECT * FROM `Categories`;");
		mysqli_stmt_execute($querycategories_prepare);
		mysqli_stmt_bind_result($querycategories_prepare,$col1,$col2,$col3,$col4,$col5,$col6);
		
		while(mysqli_stmt_fetch($querycategories_prepare)){
			  echo "<option value=$col1>$col2</option>";
		}
				
		mysqli_close($dbhandle);
	?>
	<?php
		echo $_GET['searchcategories'.$row['value']];
		echo $_POST['searchcategories'];
		echo $_POST['searchcategories'.$row['value']];
		echo "<H1>Hello</H1>";
	?>
	</select>
	Sub-Category: 
	<select name="searchsubcategories" id="searchsubcategories">

	</select>
	
	
</form>

<!--
<script>
function getSubCategory(val) {
	$.ajax({
	type: "POST",
	url: "subcategories.php",
	data:'CategoryID='+val,
	success: function(data){
		$("#searchsubcategories").html(data);
	}
	});
}
</script>
-->


