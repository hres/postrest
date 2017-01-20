<script src="jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#category').on('change',function(){
        var categoryID = $(this).val();
        if(categoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'category_id='+categoryID,
                success:function(html){
                    $('#subcategory').html(html);
                    $('#display').html('<option value="">Select Sub Category</option>'); 
                }
            }); 
        }else{
            $('#subcategory').html('<option value="">Select category first</option>');
            $('#display').html('<option value="">Select subcategory first</option>'); 
        }
    });
    
    $('#subcategory').on('change',function(){
        var subcategoryID = $(this).val();
        if(subcategoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'subcategory_id='+subcategoryID,
                success:function(html){
				$('#display').html(html);
                }
            }); 
        }else{
            $('#display').html('no data found'); 
        }
    });
	
	
	
	});
	
	

	
</script>

<style>
table,td,th
{
 padding:10px;
 border-collapse:collapse;
 font-family:Georgia, "Times New Roman", Times, serif;
 border:solid #eee 2px;
}
</style>

<p>
<?php
//Include database configuration file
$config = parse_ini_file('./db.ini');
$db=new	mysqli($config['hostname'], $config['username'], $config['password'], $config['dbname']);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 
echo "Connected successfully3<br /><br />";
//Get all country data
$query = $db->query("SELECT * FROM categories");
	
if ($result = $db->query("SELECT HeaderE FROM categories LIMIT 10")) {
    printf("Select returned %d rows.\n", $result->num_rows);

    /* free result set */
    $result->close();
}
	esel{printf("Error: %s\n", $mysqli->error);}

//Count total number of rows
$rowCount = $query->num_rows;
?>
<select name="category" id="category">
    <option value="">Select Category</option>
    <?php
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['CategoryID'].'">'.$row['HeaderE'].'</option>';
        }
    }else{
        echo '<option value="">Categories are not available</option>';
    }
    ?>
</select>
</p>
<p>

<select name="subcategory" id="subcategory">
    <option value="">Select category first</option>
</select>

</p>

<span id="displayy" name="displayy"></span>

<span id="display" name="display"></span>




