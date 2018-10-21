<?php
session_start();

require('../config/config.inc');

//This file contains php code that will be executed after the
//insert operation is done.
require('../view/item_insert_result_ui.inc');

// Main control logic
search_customer();

//-------------------------------------------------------------
function search_customer()
{

	// Connect to the 'test' database
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
	// This is actually an associative array, indexed by a string
	$cId = $_POST['customerId'];
  $name = $_POST['name'];
	$email = $_POST['email'];
  $count = 0;

  if (!empty($cId)){
    $count++;
  }
  if (!empty($name)){
    $count++;
  }
	if (!empty($email)){
		$count++;
	}

	//Creates the query string
  $insertStmt = "SELECT * FROM CUSTOMER ";
  if ($count > 0){
    $insertStmt .= "WHERE ";
    if (!empty($cId)){
      $count--;
      $insertStmt .= "CUSTOMER.customerID = $cId ";
      if($count > 0){
        $insertStmt .= "AND ";
      }
    }
    if(!empty($name)){
      $count--;
      $insertStmt .= "CUSTOMER.customerName = $name ";
			if($count > 0){
        $insertStmt .= "AND ";
      }
    }
		if(!empty($email)){
			$count--;
			$insertStmt .= "CUSTOMER.customerEmail"
		}

  }

  $insertStmt .= ";";

	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP";

	//Execute the query. The result will just be true or false
	$result = mysql_query($insertStmt);

	if (!$result)
	{
    if($firstname != null && $lastname != null){
  	   $message = "We could not find $firstName $lastname ". mysql_error();
    }

	}
	else{
		//If customer data is found, save to session array,
		//and redirect to modification page
		$_SESSION['result'] = mysql_fetch_assoc($result);
		redirect();
	}
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

//Redirect to the modification page
function redirect( ) {
    ob_start();
    header('Location: /~dgilm1/app/model/modify_customer_detail.php');
    ob_end_flush();
    die();
}

?>
