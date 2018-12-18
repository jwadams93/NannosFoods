<?php

require('../config/config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('../view/store_delete_result_ui.inc');

// Main control logic
delete_store_loc();

//-------------------------------------------------------------
function delete_store_loc(){

	// Connect to the 'test' database 
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);	

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
	// This is actually an associative array, indexed by a string
	$query = $_POST['query'];
	
	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$delStmt = "SELECT * FROM `RETAILSTORE`
    WHERE (`StoreCode` LIKE '%".$query."%') OR (`StoreName` LIKE '%".$query."%')";

	//Execute the query. The result will just be true or false
    $raw_result = mysql_query($delStmt);
    
    if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
             
        while($results = mysql_fetch_array($raw_results)){
        // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
         
            echo "<p><h3>".$results['StoreCode']."</h3>".$results['StoreName']."</p>";
            // posts results gotten from database(title and text) you can also show id ($results['id'])
        }
         
    }
    else{ // if there is no matching rows do following
        echo "No results";
    }

	$message = "";

	if (!$result) 
	{
  	  $message = "Error in deleting Store: $StoreName , $Address: ". mysql_error();
	}
	else
	{
	  $message = "Data for Store deleted successfully.";
	  
	}

	ui_show_store_loc_result($message);
			   
}

function connect_and_select_db($server, $username, $pwd, $dbname)
{
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

?>
