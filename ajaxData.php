<?php

//update with GitHub database
include('config.php');


if(isset($_POST["category_id"]) && !empty($_POST["category_id"])){
    //Get all subcategory data
    $query = $db->query("SELECT * FROM subcategories WHERE CategoryID = ".$_POST['category_id']." ORDER BY TopicE ASC");
    
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
    $query = $db->query("SELECT * FROM products WHERE SubCategoryID = ".$_POST['subcategory_id']." ORDER BY NameE ASC");
    
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
  {  
   	$CompanyName=mysql_query("SELECT NameE FROM companies WHERE CompanyID='$CompanyID'");
	$row2=mysql_fetch_row($CompanyName);
	
   echo $row2[0];

  }
  
  ?>
  
 


