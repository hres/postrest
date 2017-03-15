<?php

//update with GitHub database
$config = parse_ini_file('./db.ini');
$db = new mysqli($config['hostname'], $config['username'], $config['password'],$config['dbname']);
$db->set_charset("utf8");

// Limit per page
$limit=15;
$SelectAllLimit=15;

if(isset($_POST["category_id"]) && !empty($_POST["category_id"]) && ($_POST["category_id"]=="SelectAll")){
	

		
    $query = $db->query("SELECT SubCategoryID FROM SubCategories ORDER BY TopicE ASC LIMIT 0, 1");
	
	$rowCount=$query->num_rows;; 
    if($rowCount > 0){
		?>

<p align="center">
<table border="1">
  <tr>
    <th>Company Name</th>
    <th>Product Name</th>
    <th>Acceptance Date</th>
  </tr>
  <?php  
        while($row = $query->fetch_assoc()){ ?>
  <tr>
    <td colspan="3"><?php SubCategoryName($row['SubCategoryID']); ?></td>
  </tr>
  <?php
		
		$rowListCountsforSubID = $db->query("SELECT ProductID FROM Products Where SubCategoryID=".$row['SubCategoryID'].""); 
        $numberofList=$rowListCountsforSubID->num_rows;
		
		
		
		
// If number of products in a subcategory is less than 15		
				
		if($numberofList <= $SelectAllLimit)
		{

		
		$queryList = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 JOIN Companies as c1 ON p1.CompanyID=c1.CompanyID WHERE p1.SubCategoryID=".$row['SubCategoryID']." ORDER BY CompanyName ASC LIMIT 0, $SelectAllLimit");
		
	
		 

	 
		 
		  $rowListCount=$queryList->num_rows; 
		 	 
		 // begin
		 
		 if($rowListCount > 0){ 
    
	
        while($rowList = $queryList->fetch_assoc()){ 
        
	?>
  <tr>
    <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $rowList['CompanyID'];?>');"><?php echo $rowList['CompanyName'] ?></a></p></td>
    <td><p><?php echo $rowList['ProductName']; ?></p></td>
    <td><p>
        <?php FormatDate($rowList['ApprovalDate']) ?>
      </p></td>
  </tr>
  <?php
      } 
		
$NextSubLimit=1;
$NextProductLimit=0;
$pageID=1;
$PreviousSubLimit=-2;
$PreviousProductLimit=-2;



		?>
</table>
</p>

<div class="pagingDiv">
  <p>
    <?php pagingAll ($NextSubLimit, $NextProductLimit, $PreviousSubLimit, $PreviousProductLimit, $pageID);?>
  </p>
</div>
<?php    
         
    }else{
        echo 'No product list';
    }
		 
		 
		}
		
// End of Less than 15 product list

// If number of products in a subcateogry is great than 15	
		
	else {
		{
	
		$queryList = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 INNER JOIN Companies as c1 ON p1.SubCategoryID=".$row['SubCategoryID']." WHERE p1.CompanyID=c1.CompanyID ORDER BY CompanyName ASC LIMIT 0,$SelectAllLimit");
		
	
		 

		 $rowListCount=$queryList->num_rows; 
		
		 	 
		 // begin
		 
		 if($rowListCount > 0){ 
    
	
        while($rowList = $queryList->fetch_assoc()){ 
        
	?>
<tr>
  <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $rowList['CompanyID'];?>');"><?php echo $rowList['CompanyName'] ?></a></p></td>
  <td><p><?php echo $rowList['ProductName']; ?></p></td>
  <td><p>
      <?php FormatDate($rowList['ApprovalDate']) ?>
    </p></td>
</tr>
<?php
  

	
        } 
  $NextProductLimit=$SelectAllLimit;		
  $NextSubLimit=0;
  $pageID=1;
  $PreviousSubLimit=-1;
  $PreviousProductLimit=-1;
  

		?>
</table>
</p>
<div class="pagingDiv">
  <p>
    <?php pagingAll ($NextSubLimit, $NextProductLimit, $PreviousSubLimit, $PreviousProductLimit, $pageID);?>
  </p>
</div>

<?php    
         
    }else{
        echo 'No product listed';
    }
		 
		 
		}
		
	}
		 
		 
		 
		// end
		?>
<?php }?>
<?php
		
		
    }else{
       echo 'No data for Select All option';
    }
	
	
}



// Select Next page & Previous
if(isset($_POST["subCat_limit_next"]) && isset($_POST["product_limit_next"])){

$NextSubLimit =$_POST["subCat_limit_next"];
$NextProductLimit=$_POST["product_limit_next"];
$counter=0;





 
    $querySub = $db->query("SELECT * FROM SubCategories ORDER BY TopicE ASC LIMIT $NextSubLimit, 1");
	
	$rowCount=$querySub->num_rows; 
    if($rowCount > 0){
		?>
<p align="center">
<table border="1">
  <tr>
    <th>Company Name</th>
    <th>Product Name</th>
    <th>Acceptance Date</th>
  </tr>
  <?php  
        while($row = $querySub->fetch_assoc()){ ?>
  <tr>
    <td colspan="3"><?php SubCategoryName($row['SubCategoryID']); ?></td>
  </tr>
  <?php
		
		$rowListCountsforSubID = $db->query("SELECT ProductID FROM Products Where SubCategoryID=".$row['SubCategoryID'].""); 
		
		
	
		
	// If number of products in a subcategory is less than 15	
			$numberofList=$rowListCountsforSubID->num_rows;
		
			
			
			if($numberofList <= $SelectAllLimit)
		{
	
		
		
		$queryList = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 JOIN Companies as c1 ON p1.CompanyID=c1.CompanyID WHERE p1.SubCategoryID=".$row['SubCategoryID']." ORDER BY CompanyName ASC LIMIT $NextProductLimit, $SelectAllLimit");
		
		
		
		

		 

	 $rowListCount=$queryList->num_rows; 
		 	 
		 // begin
		 
		 if($rowListCount > 0){ 
    
	
        while($rowList = $queryList->fetch_assoc()){ 
        
	?>
  <tr>
    <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $rowList['CompanyID'];?>');"><?php echo $rowList['CompanyName'] ?></a></p></td>
    <td><p><?php echo $rowList['ProductName']; ?></p></td>
    <td><p>
        <?php FormatDate($rowList['ApprovalDate']) ?>
      </p></td>
  </tr>
  <?php
  


 
	
        }
		
			   $NextProductLimit=0;
		 
		  
		$PreviousSubLimit=$NextSubLimit-1;
		
		$NextSubLimit=$NextSubLimit + 1;
		
		$queryPrevious = $db->query("SELECT SubCategoryID FROM SubCategories ORDER BY TopicE ASC LIMIT $PreviousSubLimit, 1");
		$rowCountPrevious=$queryPrevious->num_rows; 
		
		
		
		if($rowCountPrevious > 0){
	 
			while($rowPrevious = $queryPrevious->fetch_assoc()){ 
	  
			$ProductsinSubcategory = $db->query("SELECT ProductID FROM Products Where SubCategoryID=".$rowPrevious['SubCategoryID'].""); 
			
			$NumberOfProductsinSubcategory = $ProductsinSubcategory->num_rows; 
			
			if($NumberOfProductsinSubcategory <=$SelectAllLimit)
			{
					$PreviousProductLimit=0;
						
						// Remove next button at the last page
						$queryNumberofSub=$db->query("SELECT SubCategoryID FROM SubCategories")->num_rows;
						
						
						if($queryNumberofSub ==$NextSubLimit)
						{
						$pageID=0;
						
						}
						else
						{
						$pageID=2;
						
						}
						
						// end of removal of next button
			}
			else
			{
				$PreviousProductLimit = (float)$NumberOfProductsinSubcategory /$SelectAllLimit;
				$PreviousProductLimit = (int)$PreviousProductLimit;
				$PreviousProductLimit = $PreviousProductLimit *$SelectAllLimit;
			
							
				$pageID=2;
				
			}
		 }
		   
		   
		   
		   }
		 
		 
		  
		 
		 
		 
		 ?>
</table>
</p>
<div class="pagingDiv">
  <p>
    <?php pagingAll ($NextSubLimit, $NextProductLimit, $PreviousSubLimit, $PreviousProductLimit, $pageID);?>
  </p>
</div>

<?php    
         
    }else{
        echo 'No product listed';
    }
		 
		 
		}
		
// End of Less than 15 product list

// If number of products  is great than 15	
		
	else {
	
	
		 	$queryList = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 JOIN Companies as c1 ON p1.CompanyID=c1.CompanyID WHERE p1.SubCategoryID=".$row['SubCategoryID']." ORDER BY CompanyName ASC LIMIT $NextProductLimit, $SelectAllLimit");
			
			

		 $rowListCount=$queryList->num_rows; 
		 
		
		 	 
		 // begin
		 
		 if($rowListCount > 0){ 
    
	
        while($rowList = $queryList->fetch_assoc()){ 
        
	?>
<tr>
  <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $rowList['CompanyID'];?>');"><?php echo $rowList['CompanyName'] ?></a></p></td>
  <td><p><?php echo $rowList['ProductName']; ?></p></td>
  <td><p>
      <?php FormatDate($rowList['ApprovalDate']) ?>
    </p></td>
</tr>
<?php
   


	
        } 
		
		$counter = $numberofList-$NextProductLimit;
		
		// Begining For Previous page variables
		if($NextProductLimit >=$SelectAllLimit)
		{
			$PreviousSubLimit =  $NextSubLimit;
			$PreviousProductLimit = $NextProductLimit - $SelectAllLimit;
		    $pageID=2;  	
		
			
	    }
		
		else
		{
			$PreviousSubLimit =  $NextSubLimit-1;
			
			
			$queryPrevious = $db->query("SELECT SubCategoryID FROM SubCategories ORDER BY TopicE ASC LIMIT $PreviousSubLimit, 1");
		    $rowCountPrevious=$queryPrevious->num_rows; 
		
				if($rowCountPrevious > 0){
			 
				while($rowPrevious = $queryPrevious->fetch_assoc()){ 
		  
				$ProductsinSubcategory = $db->query("SELECT ProductID FROM Products Where SubCategoryID=".$rowPrevious['SubCategoryID'].""); 
				
				$NumberOfProductsinSubcategory = $ProductsinSubcategory->num_rows; 
				
				if($NumberOfProductsinSubcategory <=$SelectAllLimit)
				{
							$PreviousProductLimit=0;
						
							
								// Remove next button at the last page
						$queryNumberofSub=$db->query("SELECT SubCategoryID FROM SubCategories")->num_rows;
						
					
						
						if($queryNumberofSub ==$NextSubLimit)
						{
						$pageID=0;
						
						}
						else
						{
						
						$pageID=2;
					
						
						}
						
						// end of removal of next button
				}
				else
				{
						$PreviousProductLimit = (float)$NumberOfProductsinSubcategory /$SelectAllLimit;
			$PreviousProductLimit = (int)$PreviousProductLimit;
			$PreviousProductLimit = $PreviousProductLimit *$SelectAllLimit;
			
			echo 'Previous Prdo: ';
			echo $PreviousProductLimit;
		
			
			$pageID=2;
					
				}
				
				 }}
			
			
			
	    }
		
		
		// End of Previous page variables
		
		// Begining For Next page variables
		
		if($counter<$SelectAllLimit)
		{
		 $NextProductLimit	=0;
		 $NextSubLimit=$NextSubLimit+1;

		
		}
		else
		{
		   $NextSubLimit=$NextSubLimit;
		   $NextProductLimit=$NextProductLimit+$SelectAllLimit;
		  
		}
		
		// End of Next page variables
 
    
		
		
		?>
</table>
<div class="pagingDiv">
  <p>
    <?php pagingAll ($NextSubLimit, $NextProductLimit, $PreviousSubLimit, $PreviousProductLimit, $pageID);?>
  </p>
</div>
</p>
<?php    
         
    }else{
        echo 'No product list';
    }
		 
		 
		}
		

		 

		
 }?>
<?php
		
		
    }else{
       echo 'No data for Select All option';
    }

	
	}

// End of Select All Next Page



// Select All Last Page
if(isset($_POST["SelectAllLastpage"])){
	
	?>
<p align="center">
<table border="1">
  <tr>
    <th>Company Name</th>
    <th>Product Name</th>
    <th>Acceptance Date</th>
  </tr>
  <?php  
	
	$NumberSubIDs = $db->query("SELECT * FROM SubCategories")->num_rows; 
	$lastSubID=$NumberSubIDs-1;
		
	$query = $db->query("SELECT * FROM SubCategories ORDER BY TopicE ASC LIMIT $lastSubID, 1");
	$rowCount = $query->num_rows;
	 if($rowCount > 0){ 
	 while($rowList = $query->fetch_assoc()){ ?>
  <tr>
    <td colspan="3"><?php SubCategoryName($rowList['SubCategoryID']); ?></td>
  </tr>
  <?php  
	 
	 $queryList = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 JOIN Companies as c1 ON p1.CompanyID=c1.CompanyID WHERE p1.SubCategoryID=".$rowList['SubCategoryID']." ORDER BY CompanyName ASC");
	 
	 $numberOfItems = $queryList->num_rows;
		
		if($numberOfItems <=$SelectAllLimit)
		{
			 while($rowList = $queryList->fetch_assoc()){ 
        
	?>
  <tr>
    <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $rowList['CompanyID'];?>');"><?php echo $rowList['CompanyName'] ?></a></p></td>
    <td><p><?php echo $rowList['ProductName']; ?></p></td>
    <td><p>
        <?php FormatDate($rowList['ApprovalDate']) ?>
      </p></td>
  </tr>
  <?php
  
  
 
  
  
	
        }
		
		 // Begining of Previous page variables
  $PreviousSubLimit = $lastSubID-1;
  

  
  $PreviousProductLimit = 0;
  // end of previous page variables
		
		 ?>
</table>
<div class="pagingDiv">
  <p>
    <?php pagingAll (0, 0,$PreviousSubLimit, $PreviousProductLimit,0);?>
  </p>
</div>
</p>
<?php	
		}
		
		else
		// if more than 15 items
		{
			$start= $numberOfItems/$SelectAllLimit;
	        $start=(int)$start*$SelectAllLimit;
			
			

			$limit = (float)($numberOfItems / $SelectAllLimit);
            $limit = ($limit - (int)$limit)*$SelectAllLimit;
			
			

			
			$queryList = $db->query("SELECT p1.CompanyID, p1.NameE as ProductName, p1.SubCategoryID, p1.ApprovalDate as ApprovalDate, c1.CompanyID as CompanyID, c1.NameE as CompanyName FROM Products as p1 JOIN Companies as c1 ON p1.CompanyID=c1.CompanyID WHERE p1.SubCategoryID=".$rowList['SubCategoryID']." ORDER BY CompanyName ASC LIMIT $start, $limit");
			
			 while($rowList = $queryList->fetch_assoc()){ 
        
	?>
<tr>
  <td><p><a href="#" id="company" onclick="AjaxCall('<?php echo $rowList['CompanyID'];?>');"><?php echo $rowList['CompanyName'] ?></a></p></td>
  <td><p><?php echo $rowList['ProductName']; ?></p></td>
  <td><p>
      <?php FormatDate($rowList['ApprovalDate']) ?>
    </p></td>
</tr>
<?php




	
        } 
		
		// Beginning of Previous Page variables
$PreviousSubLimit = $lastSubID;
$PreviousProductLimit =  $numberOfItems - $SelectAllLimit;

// End of previous page variables

		?>
</table>
<div class="pagingDiv">
  <p>
    <?php pagingAll (0, 0,$PreviousSubLimit,$PreviousProductLimit , 0);?>
  </p>
</div>
</p>
<?php
		
		}
	 } ?>
<?php 
	 
}
	 }



function pagingAll ($SubCatLimitNext, $ProductLimitNext, $SubCatLimitPrevious, $ProductLimitPrevious, $pageID)
{    
	global $db;
	$NumberOfProducts = $db->query("SELECT * FROM Products"); 
  
	


	
	if($pageID==1)
		{
			
						
            echo "<a href='#' onclick='SelectAllNextPage($SubCatLimitNext,$ProductLimitNext,$pageID)'>NEXT</a>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<a href='#' onclick='SelectAllLastPage()'>Last Page</a>";	
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	  
		}
		
     elseif($pageID==0)
	 {
		  
		 	echo "<a href='#' onclick='SelectAllFirstPage()'>First Page</a>";
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<a href='#' onclick='SelectAllNextPage($SubCatLimitPrevious,$ProductLimitPrevious,$pageID)'>PREVIOUS</a>";
		 
	  }		
		
else
	{
		  	echo "<a href='#' onclick='SelectAllFirstPage()'>First Page</a>";
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			
			If($SubCatLimitPrevious==0 && $ProductLimitPrevious==0)
			{
			echo "<a href='#' onclick='SelectAllFirstPage()'>PREVIOUS</a>";
			}
			else
			{		
			echo "<a href='#' onclick='SelectAllNextPage($SubCatLimitPrevious,$ProductLimitPrevious,$pageID)'>PREVIOUS</a>";
			}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<a href='#' onclick='SelectAllNextPage($SubCatLimitNext,$ProductLimitNext,$pageID)'>NEXT</a>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<a href='#' onclick='SelectAllLastPage()'>Last Page</a>";	
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";


	}
		

}




if(isset($_POST["category_id"]) && !empty($_POST["category_id"]) && ($_POST["category_id"]!="SelectAll")){
	
    //Get all subcategory data
    $query = $db->query("SELECT * FROM SubCategories WHERE BINARY CategoryID = ".$_POST['category_id']." ORDER BY TopicE ASC");
    
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
		echo 'Select Sub Category';
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
	
        } ?>
        
		</table>
        
           <div class="pagingDiv"><?php paging ($_POST["subcategory_id"],$total,$_POST["page_id"], $TotalCount);?></div></p>
     <?php    
         
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
	
	?>
	
	<div class="divClass">
Number of items found: <?php echo $TotalCount; ?> <br />
Page: <?php if ($pageid==0) echo $pageid+1; else echo $pageid; ?>/<?php echo $total; ?> <br /><br />
</div>
	
	<?php
	echo "<br /><br /><br />";
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

	
<?php } ?>
