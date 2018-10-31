<?php
   session_start();

   require('../config/config.inc');

   connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

   function connect_and_select_db($server, $username, $pwd, $dbname){
	// Connect to db server
	$conn = mysql_connect($server, $username, $pwd);

	if (!$conn) {
	    echo "Unable to connect to DB: " . mysql_error();
    	    exit;
	}

	// Select the database	
	$dbh = mysql_select_db($dbname);
	if (!$dbh){
    		echo "Unable to select ".$dbname.": " . mysql_error();
		exit;
	}
    }

    if(isset($_POST['search'])){

        $query = $_POST['query'];

        $query = htmlspecialchars($query); 
        
        $query = mysql_real_escape_string($query);
        // makes sure nobody uses SQL injection
         
        $raw_results = mysql_query("SELECT * FROM VENDOR
            WHERE (`VendorCode` LIKE '%$query%') OR (`VendorName` LIKE '%$query%')") or die(mysql_error()); 
    }
?>


 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Vendor Search | Nanno's Foods</title>
</head>

<body>

    

    <?php if(isset($_SESSION['message'])): ?>

        <div class="alert alert-<?=$_SESSION['msg_type']?>">

            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>

        </div>

    <?php endif ?>

    <div class="container">
        <p>What is the Vendor code or name of the Vendor you would like to search?</p>

        <div class="row justify-content-center">
            <form action="vendorCRUD.php" method="POST">
                <input type="text" name="query">
                <input type="submit" name="search" class="btn btn-primary" value="Search">
                <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./vendor_main.html'">
            </form>
        </div>
        <table class="table">
        <?php
            if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                echo "<thead>
                        <tr>
                        <th>Vendor Code</th>
                        <th>Vendor Name</th>
                        <th>Vendor Active Status</th> 
                        <th colspan='2'>Action</th>
                      </thead>
                      <tbody>";

                while($results = mysql_fetch_array($raw_results)){
                // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                    echo "<tr>"."<td>".$results['VendorCode']."</td>"
                              ."<td>".$results['VendorName']."</td>"
                              ."<td>".$results['ActiveStatus']."</td>"
                              ."<td>".
                              "<input type='button' name='modify' value='Modify' class='btn btn-info' onClick=".'"window.location='."'./modify_vendor_ui.php?VendorCode=".$results['VendorCode']."'".'"/>'
                              ."</td>"
                              ."<td>".
                                "<input type='button' name='delete' value='Delete' class='btn btn-danger' onClick=".'"window.location='."'../model/vendor_delete.php?VendorCode=".$results['VendorCode']."'".'"/>'
                              ."</td>"."</tr>";
                }
                echo "</tbody>";
            }
            else{ // if there is no matching rows do following
                echo '<center>
              <br/><br/>
              <h5>Vendor not found! Would you like to add a new vendor?</h5>
              <button value="newVendor" name="newVendor" class="btn btn-warning"
                onclick="window.location='.'\'./add_vendor_ui.php\''.'">Add New Vendor</button>
              </center>';
            }
        ?>
        </table>
    </div>
</body>
</html>