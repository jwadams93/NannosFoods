<?php

require('../config/config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('../view/item_insert_result_ui.inc');

// Main control logic
insert_customer();

//-------------------------------------------------------------
function insert_customer()
{

	// Connect to the database
        // The parameters are defined in the config.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

	// Get the information entered into the webpage by the user
  // These are available in the super global variable $_POST
	// This is actually an associative array, indexed by a string
	$customerName = $_POST['name'];
	$address = $_POST['address'];
	$city = $_POST['city'];
  $state = $_POST['state'];
  $zipcode = $_POST['zipcode'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$insertStmt = "INSERT INTO `CUSTOMER` (customerName, Address, City, State, Zip, Phone, customerEmail)
			   	 			 VALUES ( '$customerName', '$address', '$city', '$state',
									        '$zipcode', '$phone', '$email')";

	//Execute the query. The result will just be true or false
	$result = mysql_query($insertStmt);

	$message = "";

	if (!$result)
	{
  	  $message = "Error in inserting new customer:  ". mysql_error();
	}
	else
	{
	  $message = "New customer inserted successfully.";

	}

ui_show_result($message);

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
