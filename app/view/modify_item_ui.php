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

if(isset($_GET['ItemId'])){
    $ItemId = $_GET['ItemId'];
}

$query = "SELECT * FROM INVENTORYITEM WHERE ItemId = '$ItemId'";

$results = mysql_fetch_array(mysql_query($query));

//Gather Active Vendor data
$vendorQuery= mysql_query("SELECT * FROM VENDOR WHERE ActiveStatus = 'active'");

$currentVendorQuery= "SELECT * FROM VENDOR WHERE VendorID = ". $results['VendorId'];
$currentVendor= mysql_fetch_array(mysql_query($currentVendorQuery));
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
        <form action="../model/item_modify.php" method='post'>

      <?php
          echo "<h1>You are currently modifying ";
          echo $results['Description'];
          echo " (Item id: ";
          echo $results['ItemId'];
          echo ") </h1>" ;
      ?>

          <input type="hidden" name="ItemId" value="<?php echo $results['ItemId'] ?>">

          <div class="form-group">
            <label>Description</label>
            <input type="text" name="Description" value="<?php echo $results['Description']?>" class="form-control" required>
          </div>

          <div class="form-group">
            <label>PromoDescription</label>
            <input type="text" name="PromoDescription" value="<?php echo $results['PromoDescription']?>" class="form-control">
          </div>

          <div class="form-group">
            <label>Size</label>
            <input type="text" name="Size" value="<?php echo $results['Size']?>" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Division</label>
            <select name="Division" class="custom-select form-control" required>
              <option selected><?php echo $results['Division']?></option>
              <option value="Food Convenience">Food Convenience</option>
              <option value="Food Grocery">Food Grocery</option>
              <option value="General Merchandise">General Merchandise</option>
              <option value="Miscellaneous">Miscellaneous</option>
              <option value="Seasonal Merchandise">Seasonal Merchandise</option>
            </select>
          </div>

          <div class="form-group">
            <label>Department</label>
            <input type="text" name="Department" value="<?php echo $results['Department']?>" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Category</label>
            <select name="Category" class="custom-select form-control" required>
              <option selected><?php echo $results['Category']?></option>
              <option value="Candy & Food Items">Candy & Food Items</option>
              <option value="Tobacco">Tobacco</option>
              <option value="Beverage Alcohol">Beverage Alcohol</option>
              <option value="Stationery/plyg crds">Stationery/plyg crds</option>
              <option value="Electronics">Electronics</option>
              <option value="Health Aids">Health Aids</option>
              <option value="Toys">Toys</option>
              <option value="Housewares">Housewares</option>
              <option value="Fashion Accessories">Fashion Accessories</option>
              <option value="Lawn & GDN/Patio">Lawn & GDN/Patio</option>
            </select>
          </div>

          <div class="form-group">
            <label>Item Cost</label>
            <input type="text" name="ItemCost" value="<?php echo $results['ItemCost']?>" class="form-control"
            pattern="[0-9]*.[0-9]{2}" title="Cost must be in X.XX format" required>
          </div>

          <div class="form-group">
            <label>Item Retail</label>
            <input type="text" name="ItemRetail" value="<?php echo $results['ItemRetail']?>" class="form-control"
            pattern="[0-9]*.[0-9]{2}" title="Retail cost must be in X.XX format" required/>
          </div>

          <div class="form-group">
            <label>Image File Name</label>
            <input type="text" name="ImageFileName" value="<?php echo $results['ImageFileName']?>" class="form-control">
          </div>

          <div class="form-group">
            <label>Vendor</label>
            <select name="VendorId" class="custom-select form-control" required>
              <option value="<?php echo $currentVendor['VendorId']?>" selected><?php echo $currentVendor['VendorName']?></option>

                <?php
                  while($vendor_result = mysql_fetch_array($vendorQuery)){
                    if($vendor_result['VendorName'] != $currentVendor['VendorName']){
                      echo "<option value='".$vendor_result['VendorId']."'>";
                      echo $vendor_result['VendorName'];
                      echo '</option>';
                    }
                  }
                ?>
            </select>
          </div>

          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-primary" value="Reset">
            <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./item_main.html'">
          </div>
      </form>
    </div>
  </div>
</body>
</html>