<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="./jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#category').on('change',function(){
        var categoryID = $(this).val();
	    if(categoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
				data:'category_id='+categoryID,
				success:function(html){
                	if(categoryID!='SelectAll'){
					$('#subcategory').html(html);	
                    $('#displayresults').html('Select subcategory'); 
					}
					else
					{
					$('#subcategory').html('<option value="">Sélectionner tout</option>');		
					$('#displayresults').html(html); 
					}
					
                }
            }); 
        }else{
            $('#subcategory').html('<option value="">Sélectionner une catégorie en premier</option>');
            $('#displayresults').html('<option value="">Sélectionner la sous-catégorie en premier</option>'); 
        }
    });
    
    $('#subcategory').on('change',function(){
        var subcategoryID = $(this).val();
		var pageID = 0;
        if(subcategoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
                data:{'subcategory_id':subcategoryID,'page_id':+pageID},
			    success:function(html){
				$('#displayresults').html(html);
                }
            }); 
        }else{
            $('#displayresults').html('no data found'); 
        }
    });
	

	});
	
	function SelectAllSubFirstPage (CategoryID) {
		var subcategoryID= 'SelectAll '+CategoryID;
		var pageID = 0;
        if(subcategoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
                data:{'subcategory_id':subcategoryID,'page_id':+pageID},
			    success:function(html){
				$('#displayresults').html(html);
                }
            }); 
        }else{
            $('#displayresults').html('no data found'); 
        }
  
		
	}
	

	function SelectAllFirstPage() {
		
		var categoryIDAll = 'SelectAll';
		if(categoryIDAll){
			 $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
				data:'category_id='+categoryIDAll,
				success:function(html){
					$('#subcategory').html('<option value="">Sélectionner tout</option>');		
					$('#displayresults').html(html); 
				}
				
				});
				
			
		}
		else{
            $('#subcategory').html('<option value="">Sélectionner une catégorie en premier</option>');
            $('#displayresults').html('<option value="">Sélectionner la sous-catégorie en premier</option>'); 
        }
		
		
	}
	
	
	function SelectAllNextPage(SubCatLimit,ProductLimit, pageID) {
		
		var SubCatLimit=SubCatLimit;
		var ProductLimit=ProductLimit;
		var pageID=pageID
		if(SubCatLimit || ProductLimit){
			 $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
				data:{'subCat_limit_next':+SubCatLimit,'product_limit_next':+ProductLimit, 'page_id':+pageID},
				success:function(html){
					$('#subcategory').html('<option value="">Sélectionner tout</option>');		
					$('#displayresults').html(html); 
				}
				
				});
				
			
		}
	}
	
	
		function SelectAllLastPage() {
		
		var SelectAllLastpage = 'LastPage';
		if(SelectAllLastpage){
			 $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
				data:'SelectAllLastpage='+SelectAllLastpage,
				success:function(html){
					$('#subcategory').html('<option value="">Sélectionner tout</option>');		
					$('#displayresults').html(html); 
				}
				
				
			
				});
		}
				
				else {
				 $('#displayresults').html('Error'); 
				}
				
				
	}
	
	
		function SelectAllSubNextPage(CategoryID, SubCatLimit,ProductLimit, pageID) {
		
		var SubCatLimit=SubCatLimit;
		var ProductLimit=ProductLimit;
		var pageID=pageID;
		var CategoryID=CategoryID;
		if(SubCatLimit || ProductLimit || CategoryID){
			 $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
				data:{'category_SubSelectAll_ID':+CategoryID,'subCat_selectall_next':+SubCatLimit,'product_SubSelectAll_next':+ProductLimit, 'page_subSelectAll_id':+pageID},
				success:function(html){
					$('#subcategory').html('<option value="">Select All</option>');		
					$('#displayresults').html(html); 
				}
				
				});
				
			
		}
	}
	

	


	
	
	
	function AjaxCall(Cid) {
	
     var CompanyID=Cid;
        if(CompanyID){
            $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
                data:'company_id='+CompanyID,
                success:function(html){
				$('#displayresults').html(html);
                }
            }); 
        }else{
            $('#displayresults').html('empty!'); 
       }
  
    
    }
	

	
	function pages(sID, pID) {
    var subcategoryID = sID;
	var pageID = pID;
        if(subcategoryID){
            $.ajax({
                type:'POST',
                url:'ajaxData_fr.php',
                data:{'subcategory_id':+subcategoryID,'page_id':+pageID},
			    success:function(html){
				$('#displayresults').html(html);
                }
            }); 
        }else{
            $('#displayresults').html('empty!'); 
        }
    
    }
    

</script>


<style type="text/css">
li{
	list-style: none;
	display:inline-block;
	padding:6px;
}
table,td,th
{
 padding:10px;
 border-collapse:collapse;
 font-family:Georgia, "Times New Roman", Times, serif;
 border:solid #eee 2px;
 }
table{
	 width:90%;
	}
.pagingDiv
{
	width:90%;
	padding:2px;
	font-family:Georgia, "Times New Roman", Times, serif;
}
.divClass
{
	padding-left:15px;
    float:left;
	width:25%;	
}
	</style>

<p>
<?php
//Include database configuration file
$config = parse_ini_file('./db.ini');
	
	
$db = new mysqli($config['hostname'], $config['username'], $config['password'],$config['dbname']);
$db->set_charset("utf8");
	if ($db->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
	
//Get all country data
$query = $db->query("SELECT * FROM Categories ORDER BY REPLACE(HeaderF,'\'','') ASC");


//Count total number of rows
$rowCount = $query->num_rows;
?>
<select name="category" id="category">
    <option value="">Choisir une catégorie</option>
    <option value="SelectAll">Sélectionner tout</option>
    
    <?php
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['CategoryID'].'">'.$row['HeaderF'].'</option>';
        }
    }else{
        echo '<option value="">empty!</option>';
    }
    ?>
</select>
</p>
<p>

<select name="subcategory" id="subcategory">
    <option value="">Sélectionner une catégorie en premier</option>
</select>

</p>

<span id="displayy" name="displayy"></span>

<span id="displayresults" name="displayresults"></span>
