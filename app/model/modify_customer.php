<?php
session_start();
require('../config/config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('../view/item_insert_result_ui.inc');

// Main control logic
modify_customer();

//-------------------------------------------------------------
function modify_customer(){

	// Connect to the 'test' database
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
	// This is actually an associative array, indexed by a string
	$row = $_SESSION['result'];
	$cId = $row['customerID'];
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
	$count = set_count();
	$query = "UPDATE `CUSTOMER` SET ";
	if(!empty($customerName)){
		$count--;
		$query .= "CUSTOMER.customerName = '$customerName'";
		if($count > 0){
			$insertStmt .= ", ";
		}
	}
	if(!empty($address)){
		$count++;
		$query .= "CUSTOMER.Address = '$address'";
		if($count > 0){
			$insertStmt .= ", ";
		}
	}
	if(!empty($city)){
		$count++;
		$query .= "CUSTOMER.City = '$city'";
		if($count > 0){
			$insertStmt .= ", ";
		}
	}
	if(!empty($state)){
		$count++;
		$query .= "CUSTOMER.State = '$state'";
		if($count > 0){
			$insertStmt .= ", ";
		}
	}
	if(!empty($zipcode)){
		$count++;
		$query .= "CUSTOMER.ZIP = '$zipcode'";
		if($count > 0){
			$insertStmt .= ", ";
		}
	}
	if(!empty($phone)){
		$count++;
		$query .= "CUSTOMER.Phone = '$phone'";
		if($count > 0){
			$insertStmt .= ", ";
		}
	}
	if(!empty($email)){
		$count++;
		$query .= "CUSTOMER.customerEmail = '$email'";
	}
	$query .= " WHERE CUSTOMER.customerID = '$cId';";

	//Execute the query. The result will just be true or false
	$result = mysql_query($query);

	$message = "";

	if (!$result)
	{
  	  $message = "Error in modifying: ". mysql_error();
	}
	else
	{
	  $message = "Data for customer updated successfully.";

	}

}

function connect_and_select_db($server, $username, $pwd, $dbname)
{
	// Connect to db server
	$conn = mysqli_connect($server, $username, $pwd);

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
function set_count(){
	$count = 0;

	if(!empty($customerName)){$count++;}
	if(!empty($address)){$count++;}
	if(!empty($city)){$count++;}
	if(!empty($state)){$count++;}
	if(!empty($zipcode)){$count++;}
	if(!empty($phone)){$count++;}
	if(!empty($email)){$count++;}

	return $count;
}
?>
