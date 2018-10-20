<?php

require('config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('store_add_result_ui.inc');

// Main control logic
insert_store_loc();

//-------------------------------------------------------------
function insert_store_loc(){

	// Connect to the 'test' database 
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);	

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
	// This is actually an associative array, indexed by a string
	$StoreId = $_POST['StoreId'];
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
	$insertStmt = "insert RETAILSTORE (StoreId, StoreCode, StoreName, 
		       Address, City, State, ZIP, Phone) values ( '$StoreId', '$StoreCode',
                      '$StoreName', '$Address', '$City', '$State', '$ZIP', '$Phone', '$ManagerName')";

	//Execute the query. The result will just be true or false
	$result = mysql_query($insertStmt);

	$message = "";

	if (!$result) 
	{
  	  $message = "Error in inserting item: $StoreName , $Address: ". mysql_error();
	}
	else
	{
	  $message = "Data for item: $StoreName , $Address inserted successfully.";
	  
	}

	store_add_result_ui($message);
			   
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
