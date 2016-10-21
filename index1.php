<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<?php include 'conn.php';
// Query the DB to see what fields are available and setup what field to serach in
echo "Search in: <select name='searchin'>";
      $querycolumns = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='$dbname' AND `TABLE_NAME`='$tablename2';";
              $columnvalue = mysql_query ($querycolumns);
              while($column = mysql_fetch_array($columnvalue)){
              echo "<option value=$column[COLUMN_NAME]>$column[COLUMN_NAME]</option>";
              }
              mysql_close();
echo "</select>";
// Ask the User what value to look for in the above selected 
echo "for values that begin with: <input type='text' name='searchfor'>";
echo "<input type='submit' name='submit' value='Submit'>";
?>
</form>
<hr>

<?php
// Take values from entry form and pass into search query
if(isset($_POST['submit']))
{ 
    $searchelement = $_POST['searchin'];
    $searchvalue = $_POST['searchfor'];
echo " Results of '$searchelement' beginging with '$searchvalue'<hr>";
}
?>

<table border = 1 width = 1280>
      <tr>
            <?php include 'conn.php';
      // Setup the header row for the search results by querying the DB for the field names and add an additional column for the link based on PDFs with Access Numbers as file names
            $querycolumns = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='$dbname' AND `TABLE_NAME`='$tablename';";
                  $columnvalue = mysql_query ($querycolumns);
                  while($column = mysql_fetch_assoc($columnvalue)){
                  echo "<th>$column[COLUMN_NAME]</th>";
                  $colcount[] = $column['COLUMN_NAME'];
                  }
             
             mysql_close();
            ?>
          <th>Link</th>
      </tr>



<?php include 'conn.php';
//Run the query and populate the table 
$queryresult = "SELECT $tablename.* FROM $tablename JOIN $tablename2 ON $tablename2.ManuCode LIKE $tablename1.MFRCode"%" WHERE $tablename2.MfgName = "%Compounding%";";
//LIKE '%$searchvalue%';";

$result = mysql_query($queryresult);
while ($row = mysql_fetch_array($result)) {
       echo "<tr>";
       //Loop through the variable because we don't know what the field name is and return the query results based on what the db has the field names as (e.g DB can change without this code changing too much)
       for($i = 0, $j = count($colcount); $i < $j ; $i++) {
                        echo "<td>";
                        echo $row[$colcount[$i]];
                        echo "</td>";
           }
       // Output a link using the AccessNum as the file name
       echo "<td> <a href=";
       echo $pdfpath;
       echo $row[$pdfname];
       echo ".pdf>Link</a> </td>";
       echo "</tr>";
       }
mysql_close();
?>



</table>
