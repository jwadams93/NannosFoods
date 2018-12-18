<?php
session_start();

require('../config/config.inc');

// Main control logic
delete_customer();

//-------------------------------------------------------------
function delete_customer(){

	// Connect to the 'test' database
        // The parameters are defined in the teach_cn.inc file
        // These are global constants
	connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

	// Get the information entered into the URL by the user
    // These are available in the super global variable $_POST
    // This is actually an associative array, indexed by a string
    if(isset($_GET['i'])){
        $customerID = $_GET['i'];
    }

	// Create a String consisting of the SQL command. Remember that
        // . is the concatenation operator. $varname within double quotes
 	// will be evaluated by PHP
	$query = "DELETE FROM CUSTOMER WHERE customerID = '$customerID'";

	//Execute the query. The result will just be true or false
	$result = mysql_query($query);

	if($result == false){
		$_SESSION['message'] = "Error deleting record! Error number:". mysql_errno();
		$_SESSION['msg_type'] = "danger";
	}else{
		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "warning";
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