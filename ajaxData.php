<?php

//update with GitHub database
$config = parse_ini_file('./db.ini');
$db = new mysqli($config['hostname'], $config['username'], $config['password'],$config['dbname']);
$db->set_charset("utf8");

// Limit per page
$limit=15;


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




if(isset($_POST["subcategory_id"]) && !empty($_POST["subcategory_id"]) && isset($_POST["page_id"])){
    //Get all product and company data
	
	if($_POST["page_id"]==0)
	{
	$start=$_POST["page_id"];
	}
	
	else
	{
	global $limit;
	$start=($_POST["page_id"]-1)*$limit;
	}
	
	
	
   $query = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 INNER JOIN Companies as c1 ON p1.SubCategoryID=".$_POST['subcategory_id']." AND p1.CompanyID=c1.CompanyID ORDER BY CompanyName ASC LIMIT $start, $limit");
	
	// for paging purpse
	$query2 = $db->query("SELECT * FROM Products WHERE BINARY SubCategoryID = ".$_POST['subcategory_id']);
    $TotalCount = $query2->num_rows;
	$total=ceil($TotalCount/$limit);
	
    
    //Count total number of rows
    $rowCount = $query->num_rows;
	   //Display Sub Category name
	SubCategoryName($_POST['subcategory_id']);
    
    //Display company and product list
    if($rowCount > 0){ 
    
	?>
    
        <p align="center">
        
        <div class="pagingDiv"><?php paging ($_POST["subcategory_id"],$total,$_POST["page_id"], $TotalCount);?>
        <table border="1">
   
        <tr><th>Company Name</th>
        <th>Product Name</th>
        <th>Acceptance Date</th>
        </tr>
        
        <?php
        while($row = $query->fetch_assoc()){ 
        
	?>

<tr>
  <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $row['CompanyID'];?>');"><?php echo $row['CompanyName'] ?></a></p></td>
  <td><p><?php echo $row['ProductName']; ?></p></td>
  <td><p><?php FormatDate($row['ApprovalDate']) ?></p></td>
</tr>
<?php
	
        }
		 echo '</table></div></p>';
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
		
  
function paging ($subID, $total, $pageid, $TotalCount)
{
	
	echo "<br />";
	if($pageid>1)
{
	$id=$pageid-1;
	echo "<div class='divClass'><a href='#' onclick='pages($subID, $id)'>Previous</a></div>"; 
}
?>



<?php

if($pageid!=$total && $total!=1)
{
	if ($pageid==0)
	{
	$id=$pageid+2;
	echo "<div class='divClass'><a href='#' onclick='pages($subID, $id)'>NEXT</a></div><br />"; 
	}
	
	else
	{
	$id=$pageid+1;
	echo "<div class='divClass'><a href='#' onclick='pages($subID, $id)'>NEXT</a></div><br />"; 
	}
	
}


echo "<ul>";
		for($i=1;$i<=$total;$i++)
		{
			if($i==$pageid) 
			{ 
			echo "<li class='current'>".$i."</li>"; 
			
			}
			
			else 
			{ 
			if($total!=1)
			{
			echo "<li><a href='#' onclick='pages($subID, ".$i.")'>".$i."</a></li>"; 
			}
			}
		}
echo "</ul>";
?>
<div class="divClass">
Number of items found: <?php echo $TotalCount; ?> <br />
Page: <?php if ($pageid==0) echo $pageid+1; else echo $pageid; ?>/<?php echo $total; ?> <br /><br />
</div>
	
<?php } ?>
  
 


