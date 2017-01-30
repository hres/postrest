<?php

//update with GitHub database
$config = parse_ini_file('./db.ini');
$db = new mysqli($config['hostname'], $config['username'], $config['password'],$config['dbname']);
$db->set_charset("utf8");



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
    SubCategoryName($_POST['subcategory_id']);	
    
    //Display company and product list
    if($rowCount > 0){ ?>
    
        <p align="center"><table border="1">
        <tr><th>Company Name</th>
        <th>Product Name</th>
        <th>Acceptance Date</th>
        </tr>
        
        <?php
        while($row = $query->fetch_assoc()){ 
        
	?>

<tr>
  <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $row['CompanyID'];?>');"><?php CompanyName($row['CompanyID']) ?></a></p></td>
  <td><p><?php echo $row['NameE']; ?></p></td>
  <td><p><?php FormatDate($row['ApprovalDate']) ?></p></td>
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
  
  if(isset($_POST["company_id"]) && !empty($_POST["company_id"])){
    //Get all product and company data
	
	$CompID=$_POST['company_id'];
    $query = $db->query("SELECT * FROM Products WHERE CompanyID = '$CompID' ORDER BY NameE ASC");
	
	if($query === false) 
{ 
   printf("Query failed: <br />"); 
   return false; 
}
    
    //Count total number of rows
    $rowCount = $query->num_rows;
	  	echo "Company: ";
	CompanyName($CompID);
    
    //Display company and product list
    if($rowCount > 0){
		 ?>
		
        <p align="center"><table border="1">
        <tr><th>Category (Sub-Category)</th>
        <th>Product Name</th>
        <th>Acceptance Date</th>
        </tr>
        
       <?php
        while($row = $query->fetch_assoc()){ 
        
	 ?>

<tr>
  <td><p><?php CategorySubCategoryName($row['SubCategoryID']); ?></p></td>	
  <td><p><?php echo $row['NameE']; ?></p></td>
   <td><p><?php FormatDate($row['ApprovalDate']) ?></p></td>
</tr>
<?php
	
        }
		 echo '</table></p>';
    }else{
        echo 'NO data2';
    }
}

  ?>
  
  <?php
  
  Function CompanyName($CompanyID)
  {  

  global $db;
  
  if ($result = $db->query("SELECT * FROM Companies WHERE BINARY CompanyID='$CompanyID'")) 
  {
     if($result->num_rows > 0)
     {
               while($row = $result->fetch_assoc())
	       		   { 
			   echo $row['NameE'];
			   }
     }
        
	/* free result set */
    $result->close();
  }
	else { 
		printf("<br />unable to connnect to Companies table");
	     }  

  }
		
		
		
  Function FormatDate($DateFromDB)
  {
  
  $time = strtotime($DateFromDB);
  $myFormatForView = date("m/d/y", $time);
  echo $myFormatForView;
  
  }
  
  Function SubCategoryName($SubCategoryID)
  {
	  global $db;
	  
	$query = $db->query("SELECT * FROM SubCategories WHERE BINARY SubCategoryID = '$SubCategoryID'");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display subcategory list
    if($rowCount > 0){
       
        while($row = $query->fetch_assoc()){ 
		
		    echo "Category :<strong> ";
			CategoryName($row['CategoryID']);
			echo "</strong><br />";
            echo "Sub-Category : <strong>".$row['TopicE']."</strong><br /><br />";
			echo "(Conditions of use:".$row['condition_use_en'].")";
        }
    }else{
        echo "No Sub-Category";
    }
}

  Function CategoryName($CategoryID)
  {
	  global $db;
	  
	$query = $db->query("SELECT * FROM Categories WHERE BINARY CategoryID = '$CategoryID'");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display subcategory list
    if($rowCount > 0){
       
        while($row = $query->fetch_assoc()){ 
            echo $row['HeaderE'];
        }
    }else{
        echo "No Category";
    }
}

Function CategorySubCategoryName($SubCategoryID)
  {
	  global $db;
	  
	$query = $db->query("SELECT * FROM SubCategories WHERE BINARY SubCategoryID = '$SubCategoryID'");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display subcategory list
    if($rowCount > 0){
       
        while($row = $query->fetch_assoc()){ 
		
		    echo  CategoryName($row['CategoryID'])."(".$row['TopicE'].")";
           
			
        }
    }else{
        echo "No data";
    }
}
		
  
  ?>
  
 


