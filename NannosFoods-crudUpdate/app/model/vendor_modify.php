<?php

require('../config/config.inc');


session_start();
// Main control logic
update_vendor();

//-------------------------------------------------------------
function update_vendor(){

	// Connect to the 'test' database 
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);	

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
    // This is actually an associative array, indexed by a string
    $VendorCode = mysql_real_escape_string($_POST['VendorCode']);
    $VendorName = mysql_real_escape_string($_POST['VendorName']);
    $Address = mysql_real_escape_string($_POST['Address']);
    $City = mysql_real_escape_string($_POST['City']);
    $State = mysql_real_escape_string($_POST['State']);
    $ZIP = mysql_real_escape_string($_POST['ZIP']);
    $Phone = mysql_real_escape_string($_POST['Phone']);
    $ContactPersonName = mysql_real_escape_string($_POST['ContactPersonName']);
    $Password = mysql_real_escape_string($_POST['Password']);
    $ActiveStatus = mysql_real_escape_string($_POST['ActiveStatus']);
        
	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$updateStmt = "UPDATE `VENDOR` SET VendorName = '$VendorName', Address = '$Address', City = '$City', State = '$State', ZIP = '$ZIP', Phone = '$Phone', ContactPersonName = '$ContactPersonName', Password = '$Password', ActiveStatus = '$ActiveStatus' WHERE VendorCode = '$VendorCode'";

	//Execute the query. The result will just be true or false
	$result = mysql_query($updateStmt);

	if($result == false){
		$_SESSION['message'] = "Error updating record! Error number:". mysql_errno() .": ". mysql_error();
		$_SESSION['msg_type'] = "danger";
	}else{
		$_SESSION['message'] = "Record has been updated!";
		$_SESSION['msg_type'] = "warning";
	}

	header("location: ../view/vendorCRUD.php");
			   
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