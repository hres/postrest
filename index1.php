<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
});
</script>
</head>
<body>
    <div class="select-boxes">
    <?php
	$config = parse_ini_file('./db.ini');
	//connection to the Server
	$dbhandle = mysqli_connect($config['hostname'], $config['username'], $config['password'],$config['dbname']) or die("Unable to connect to Server");
        
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	Category: 
	<select name="searchcategories" id="searchcategories" value="0">
		$querycategories_prepare = mysqli_stmt_init($dbhandle);
		mysqli_stmt_prepare($querycategories_prepare, "SELECT * FROM `Categories`;");
		mysqli_stmt_execute($querycategories_prepare);
		mysqli_stmt_bind_result($querycategories_prepare,$col1,$col2,$col3,$col4,$col5,$col6);
		
		while(mysqli_stmt_fetch($querycategories_prepare)){
			  echo "<option value=$col1>$col2</option>";
		}
				
	</select>
        
        
    //Get all category data
	<select name="searchcategories" id="searchcategories" value="0">
		$querycategories_prepare = mysqli_stmt_init($dbhandle);
		mysqli_stmt_prepare($querycategories_prepare, "SELECT * FROM `Categories`;");
		mysqli_stmt_execute($querycategories_prepare);
		mysqli_stmt_bind_result($querycategories_prepare,$col1,$col2,$col3,$col4,$col5,$col6);
		
		while(mysqli_stmt_fetch($querycategories_prepare)){
			  echo "<option value=$col1>$col2</option>";
		}
				
	</select>
    
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    ?>
    <select name="country" id="country">
        <option value="">Select Country</option>
        <?php
        if($rowCount > 0){
            while($row = $query->fetch_assoc()){ 
                echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
            }
        }else{
            echo '<option value="">Country not available</option>';
        }
        ?>
    </select>
    
    <select name="state" id="state">
        <option value="">Select country first</option>
    </select>
    
    <select name="city" id="city">
        <option value="">Select state first</option>
    </select>
    </div>
</body>
</html>
