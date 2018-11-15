<?php
   require('../config/config.inc');

   //This file contains php code that will be executed after the
   //insert operation is done.
   require('../view/store_delete_result_ui.inc');

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
         
        $raw_results = mysql_query("SELECT * FROM RETAILSTORE
            WHERE (`StoreCode` LIKE '%$query%') OR (`StoreName` LIKE '%$query%')") or die(mysql_error());
             
         
    }
    
    
?>


 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Store Search</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./style/style.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

        <p>What is the store code or name of the store you would like to search?</p>

        <form action="delete_store_loc_ui.php" method="POST">
            <input type="text" name="query">
            <input type="submit" name="search" class="btn btn-primary" value="Search">
          
          <table>
            <?php
            if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                echo "<thead>
                        <tr>
                          <th>Store Code</th>
                          <th>Store Name</th>
                          <th colspan='2'></th>
                      </thead>
                      <tbody>";

                while($results = mysql_fetch_array($raw_results)){
                // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                  
                    echo "<tr>"."<td>".$results['StoreCode']."</td>"
                              ."<td>".$results['StoreName']."</td>"
                              ."<td>"."<input type='button' name='modify' value='Modify'>"."</td>"
                              ."<td>"."<input type='button' name='delete' value='Delete'>"."</td>"."</tr>";
                    // posts results gotten from database you can also show id 
                }
                echo "</tbody>";
            }
            else{ // if there is no matching rows do following
                echo "No results";
            }
         ?>
        </table>
      </form>
</body>
</html>