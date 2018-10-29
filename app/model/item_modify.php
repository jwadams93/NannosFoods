<?php

require('../config/config.inc');


session_start();
// Main control logic
update_item();

//-------------------------------------------------------------
function update_item(){

	// Connect to the 'test' database 
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);	

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
    // This is actually an associative array, indexed by a string
    $ItemId = $_POST['ItemId'];
    $Description = $_POST['Description'];
    $PromoDescription = $_POST['PromoDescription'];
    $Size = $_POST['Size'];
    $Division = $_POST['Division'];
    $Department = $_POST['Department'];
    $Category = $_POST['Category'];
    $ItemCost = $_POST['ItemCost'];
    $ItemRetail = $_POST['ItemRetail'];
    $ImageFileName = $_POST['ImageFileName'];
    $VendorId = $_POST['VendorId'];
        
	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$updateStmt = "UPDATE `INVENTORYITEM` SET Description = '$Description', PromoDescription = '$PromoDescription', Size = '$Size', Division = '$Division', Department = '$Department', Category = '$Category', ItemCost = '$ItemCost', ItemRetail = '$ItemRetail', ImageFileName = '$ImageFileName', VendorId = '$VendorId' WHERE ItemId = '$ItemId'";

	//Execute the query. The result will just be true or false
	$result = mysql_query($updateStmt);

	if($result == false){
		$_SESSION['message'] = "Error updating record! Error number:". mysql_errno();
		$_SESSION['msg_type'] = "danger";
	}else{
		$_SESSION['message'] = "Record has been updated!";
		$_SESSION['msg_type'] = "warning";
	}

	header("location: ../view/itemCRUD.php");
			   
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