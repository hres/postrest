<?php

//update with GitHub database
$config = parse_ini_file('./db.ini');
$db = new mysqli($config['hostname'], $config['username'], $config['password'],$config['dbname']);



if(isset($_POST["category_id"]) && !empty($_POST["category_id"])){
    //Get all subcategory data
    $query = $db->query("SELECT * FROM SubCategories WHERE CategoryID = ".$_POST['category_id']." ORDER BY TopicE ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display subcategory list
    if($rowCount > 0){
        echo '<option value="">Select Sub Category</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['SubCategoryID'].'">'.$row['TopicE'].'</option>';
        }
    }else{
        echo '<option value="">Sub Category not available</option>';
    }
}


if(isset($_POST["subcategory_id"]) && !empty($_POST["subcategory_id"])){
    //Get all product and company data
    $query = $db->query("SELECT * FROM Products WHERE BINARY SubCategoryID = ".$_POST['subcategory_id']." ORDER BY NameE ASC");
	
	
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display company and product list
    if($rowCount > 0){
        echo '<p align="center"><table border="1">';
        while($row = $query->fetch_assoc()){ 
        
	 ?>

<tr>
  <td><p><?php CompanyName($row['CompanyID']) ?></p></td>
  <td><p><?php echo $row['NameE']; ?></p></td>
  <td><p><?php echo $row['ApprovalDate']; ?></p></td>
</tr>
<?php
	
        }
		 echo '</table></p>';
    }else{
        echo 'NO data';
    }
}

  ?>
  
  <?php
  
  Function CompanyName($CompanyID)
  {     global $db;
	if ($result = $db->query("SELECT * FROM Companies")) {
    printf("Select returned111 %d rows.\n", $result->num_rows);
    /* free result set */
    $result->close();
}
	else { printf("<br />unable to connnect to Companies table");}  
   //	$CompanyName=mysql_query("SELECT * FROM Companies WHERE BINARY CompanyID=$CompanyID");
	//$row2=mysql_fetch_row($CompanyName);
//	echo $row2[1];
  }
  
  ?>
  
 


