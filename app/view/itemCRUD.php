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
         
        $raw_results = mysql_query("SELECT * FROM INVENTORYITEM
            WHERE (`ItemId` LIKE '%$query%')") or die(mysql_error()); 
    }
?>


 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./style/style.css"/>
    <title>Item Search | Nanno's Foods</title>
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
        <p>What is the Id of the Item you would like to search for?</p>

        <div class="row justify-content-center">
            <form action="itemCRUD.php" method="POST">
                <input type="text" name="query">
                <input type="submit" name="search" class="btn btn-primary" value="Search">
                <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./item_main.html'">
            </form>
        </div>
        <table class="table">
        <?php
            if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                echo "<thead>
                        <tr>
                          <th>Item Id</th>
                          <th>Description</th>
                          <th colspan='2'>Action</th>
                      </thead>
                      <tbody>";

                while($results = mysql_fetch_array($raw_results)){
                    echo "<tr>"."<td>".$results['ItemId']."</td>"
                              ."<td>".$results['Description']."</td>"
                              ."<td>".
                              "<input type='button' name='modify' value='Modify' class='btn btn-info' onClick=".'"window.location='."'./modify_item_ui.php?ItemId=".$results['ItemId']."'".'"/>'
                              ."</td>"
                              ."<td>".
                                "<input type='button' name='delete' value='Delete' class='btn btn-danger' onClick=".'"window.location='."'../model/item_delete.php?ItemId=".$results['ItemId']."'".'"/>'
                              ."</td>"."</tr>";
                }
                echo "</tbody>";
            }
            else{ // if there is no matching rows do following
                echo "No results";
            }
        ?>
        </table>
    </div>
</body>
</html>