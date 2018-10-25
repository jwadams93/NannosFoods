<?php
   require('../config/config.inc');

   //This file contains php code that will be executed after the
   //insert operation is done.
   require('../view/store_delete_result_ui.inc');

   connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

   function connect_and_select_db($server, $username, $pwd, $dbname){
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

if(isset($_GET['StoreCode'])){
    $StoreCode = $_GET['StoreCode'];
}

$query = "SELECT * FROM RETAILSTORE WHERE StoreCode = '$StoreCode'";

$results = mysql_fetch_array(mysql_query($query));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Modify Store</title>
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <form action="../model/store_modify.php" method="POST">

                <?php echo "<p>This is the Store Code $StoreCode
                            The Store Name is ".$results['StoreName']."</p>"?>

                <input type="hidden" name="StoreCode" value="<?php echo $results['StoreCode']?>">

                <div class="form-group">
                    <label>Store Name</label>
                    <input type="text" name="StoreName" placeholder="<?php echo $results['StoreName']?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="Address" value="<?php echo $results['Address']?>" class="form-control">
                </div>
            
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="City" value="<?php echo $results['City']?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="State" value="<?php echo $results['State']?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>ZIP</label>
                    <input type="text" name="ZIP" value="<?php echo $results['ZIP']?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="Phone" value="<?php echo $results['Phone']?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Manager Name</label>
                    <input type="text" name="ManagerName" value="<?php echo $results['ManagerName']?>" class="form-control">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-primary" value="Reset">
                </div>
            </form>
        </div>
    </div>

</body>
</html>