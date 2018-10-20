<?php

require('config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('customer_insert_result_ui.inc');

// Main control logic
insert_customer();

//-------------------------------------------------------------
function insert_customer()
{

	// Connect to the 'test' database 
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
	// This is actually an associative array, indexed by a string
	$customerName = $_POST['itemId'];
	$address = $_POST['description'];
	$city = $_POST['promoDescription'];
    $state = $_POST['size'];
    $zipcode = $_POST['division'];
    $phone = $_POST['department'];
    $email = $_POST['category'];
        
	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$insertStmt = "INSERT INTO `INVENTORYITEM` (ItemId, Description, PromoDescription, 
		       Size, Division, Department, Category, ItemCost, ItemRetail, ImageFileName, VendorID) 
			   values ( '$itemId', '$description',
                      '$promoDescription', '$size', '$division',
					  '$department', '$category', '$itemCost', '$itemRetail', 
					  '$imageFileName', '$vendorId')";

	//Execute the query. The result will just be true or false
	$result = mysql_query($insertStmt);

	$message = "";

	if (!$result) 
	{
  	  $message = "Error in inserting item:  ". mysql_error();
	}
	else
	{
	  $message = "Item inserted successfully.";
	  
	}

	ui_show_teacher_insert_result($message, $lastname, $firstname, 
		$specialization, $highestdegree);
			   
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
