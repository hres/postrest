<?php

if(!empty($_POST["CategoryID"])) {
	$query ="SELECT * FROM `SubCategories` WHERE CategoryID = '" . $_POST["CategoryID"] . "'";
	$results = $dbhandle->query($query);
	mysqli_stmt_bind_result($results,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10);
?>
	<option value="">Select Category</option>
<?php
	while(mysqli_stmt_fetch($results)){
		  echo "<option value=$col1>$col3 ($col2)</option>";
	}
	foreach($results as $subCategory) {
?>
