<?php
   require('../config/config.inc');

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

if(isset($_GET['i'])){
    $id = $_GET['i'];
}

$query = "SELECT * FROM CUSTOMER WHERE customerID = '$id'";

$results = mysql_fetch_array(mysql_query($query));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Modify Customer | Nanno's Foods</title>



</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <form action="../model/customer_modify.php" method="POST">

                <?php
                    echo "<h1>You are currently modifying customer: ";
                    echo $results['Name'];
                    echo " (Customer id: ";
                    echo $results['customerID'];
                    echo ") </h1>" ;
                ?>

                <input type="hidden" name="customerID" value="<?php echo $results['customerID'];?>"
                  placeholder="<?php echo $results['customerID'];?>">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="Name" value="<?php echo $results['Name']?>"
                      placeholder="<?php echo $results['Name']?>" class="form-control" required
                      pattern="^[A-Z][a-z]*|[A-Z][a-z]*((-|\s)[A-Z][a-z]*)*"
                      title="Name Invalid: Names must begin with a capital: John, John-Brown, John Peters"/>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="Address" value="<?php echo $results['Address']?>"
                      placeholder="<?php echo $results['Address']?>" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="City" value="<?php echo $results['City']?>" class="form-control" required
                    pattern="[A-Z][a-z]*((-|\s){1}([A-Z]?[a-z]*))*"
                    title="Invalid City: Ex. City, City-Name, City-name, City Name, City name"/>
                </div>

                <div class="form-group">
                    <label>State</label>
                    <select id='state' name='State' class="custom-select form-control" required>
						            <option value="<?php echo $results['State']?>" selected><?php echo $results['State']?></option>
						            <option value='Alaska'>Alaska</option>
                        <option value='Alabama'>Alabama</option>
                        <option value='American Samoa'>American Samoa</option>
                        <option value='Arkansas'>Arkansas</option>
                        <option value='Arizona'>Arizona</option>
                        <option value='California'>California</option>
                        <option value='Colorado'>Colorado</option>
                        <option value='Connecticut'>Connecticut</option>
                        <option value='D.C.'>District of Columbia</option>
                        <option value='Delaware'>Delaware</option>
                        <option value='Florida'>Florida</option>
                        <option value='Georgia'>Georgia</option>
                        <option value='Guam'>Guam</option>
                        <option value='Hawaii'>Hawaii</option>
                        <option value='Iowa'>Iowa</option>
                        <option value='Idaho'>Idaho</option>
                        <option value='Illinois'>Illinois</option>
                        <option value='Indiana'>Indiana</option>
                        <option value='Kansas'>Kansas</option>
                        <option value='Kentucky'>Kentucky</option>
                        <option value='Louisiana'>Louisiana</option>
                        <option value='Massachusetts'>Massachusetts</option>
                        <option value='Maryland'>Maryland</option>
                        <option value='Maine'>Maine</option>
                        <option value='Michigan'>Michigan</option>
                        <option value='Minnesota'>Minnesota</option>
                        <option value='Missouri'>Missouri</option>
                        <option value='Mississippi'>Mississippi</option>
                        <option value='Montana'>Montana</option>
                        <option value='North Carolina'>North Carolina</option>
                        <option value='North Dakota'>North Dakota</option>
                        <option value='Nebraska'>Nebraska</option>
                        <option value='New Hampshire'>New Hampshire</option>
                        <option value='New Jersey'>New Jersey</option>
                        <option value='New Mexico'>New Mexico</option>
                        <option value='Nevada'>Nevada</option>
                        <option value='New York'>New York</option>
                        <option value='Ohio'>Ohio</option>
                        <option value='Oklahoma'>Oklahoma</option>
                        <option value='Oregon'>Oregon</option>
                        <option value='Pennsylvania'>Pennsylvania</option>
                        <option value='Puerto Rico'>Puerto Rico</option>
                        <option value='Rhode Island'>Rhode Island</option>
                        <option value='South Carolina'>South Carolina</option>
                        <option value='South Dakota'>South Dakota</option>
                        <option value='Tennessee'>Tennessee</option>
                        <option value='Texas'>Texas</option>
                        <option value='Utah'>Utah</option>
                        <option value='Virginia'>Virginia</option>
                        <option value='Virgin Islands'>Virgin Islands</option>
                        <option value='Vermont'>Vermont</option>
                        <option value='Washington'>Washington</option>
                        <option value='Wisconsin'>Wisconsin</option>
                        <option value='West Virginia'>West Virginia</option>
                        <option value='Wyoming'>Wyoming</option>
					           </select>
                </div>

                <div class="form-group">
                    <label>Zip</label>
                    <input type="text" name="Zip" value="<?php echo $results['Zip']?>" class="form-control" required
                    pattern="[0-9]{5}" title="Zipcode must be 5 digits exactly" />
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="Phone" value="<?php echo $results['Phone']?>" class="form-control"
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="Phone number must be of the format: XXX-XXX-XXXX"/>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" value="<?php echo $results['Email']?>" class="form-control"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-primary" value="Reset">
                    <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./customer_main.html'">
                </div>
            </form>

        </div>
    </div>

</body>
</html>