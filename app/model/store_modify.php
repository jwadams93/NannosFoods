<?php

require('../config/config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('../view/store_add_result_ui.inc');

// Main control logic
update_store_loc();

//-------------------------------------------------------------
function update_store_loc(){

	// Connect to the 'test' database 
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);	

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
    // This is actually an associative array, indexed by a string
    $StoreCode = $_POST['StoreCode'];
	$StoreName = $_POST['StoreName'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $State = $_POST['State'];
    $ZIP = $_POST['ZIP'];
    $Phone = $_POST['Phone'];
    $ManagerName = $_POST['ManagerName'];
        
	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$updateStmt = "UPDATE `RETAILSTORE` SET StoreName = '$StoreName', Address = '$Address', City = '$City', State = '$State', ZIP = '$ZIP', Phone = '$Phone', ManagerName = '$ManagerName' WHERE StoreCode = '$StoreCode'";

	//Execute the query. The result will just be true or false
	$result = mysql_query($updateStmt);

	$message = "";

	if (!$result) 
	{
  	  $message = "Error in updating Store: $StoreName , $Address: ". mysql_error();
	}
	else
	{
	  $message = "Data for Store: $StoreName , $Address updated successfully.";
	  
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