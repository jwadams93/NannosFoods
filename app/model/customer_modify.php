<?php

require('../config/config.inc');

session_start();
// Main control logic
update_customer();

//-------------------------------------------------------------
function update_customer(){

	// Connect to the 'test' database
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

	// Get the information entered into the webpage by the user
        // These are available in the super global variable $_POST
    // This is actually an associative array, indexed by a string
    $customerID = $_POST['customerID'];
	$Name = $_POST['Name'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $State = $_POST['State'];
    $Zip = $_POST['Zip'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];

	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$updateStmt = "UPDATE `CUSTOMER` SET
      Name = '$Name', Address = '$Address',
      City = '$City', State = '$State', Zip = '$Zip',
      Phone = '$Phone', Email = '$Email'
      WHERE customerID = '$customerID'";

	//Execute the query. The result will just be true or false
	$result = mysql_query($updateStmt);

	if($result == false){
		$_SESSION['message'] = "Error updating record! Error number:". mysql_errno();
		$_SESSION['msg_type'] = "danger";
	}else{
		$_SESSION['message'] = "Record has been updated!";
		$_SESSION['msg_type'] = "success";
	}
	

	header("location: ../view/customerCRUD.php");

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