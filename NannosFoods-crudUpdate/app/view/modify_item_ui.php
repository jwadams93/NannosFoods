<?php
  require('./access_db.php');

  connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">

    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
    <title>Modify Store</title>
</head>
<body>

    <?php require('./header/header.php'); ?>


    <div class="container container shadow p-4 mb-5 mt-5 bg-white rounded">
      <?php
          echo "<h1>Modifying ";
          echo $results['Description'];
          echo " (Item id: ";
          echo $results['ItemId'];
          echo ") </h1>" ;
      ?>

        <form action="../model/item_modify.php" method='post'>

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

        <div class="form-row no-gutters">
          <div class="form-group col-md-6">
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

          <div class="form-group col-md-6">
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
        </div>


          <div class="form-group">
            <label>Department</label>
            <input type="text" name="Department" value="<?php echo $results['Department']?>" class="form-control" required>
          </div>

        <div class="form-row no-gutters">

          <div class="form-group col-md-6">
            <label>Item Cost</label>
            <input type="text" name="ItemCost" value="<?php echo $results['ItemCost']?>" class="form-control"
            pattern="[0-9]*.[0-9]{2}" title="Cost must be in X.XX format" required>
          </div>

          <div class="form-group col-md-6">
            <label>Item Retail</label>
            <input type="text" name="ItemRetail" value="<?php echo $results['ItemRetail']?>" class="form-control"
            pattern="[0-9]*.[0-9]{2}" title="Retail cost must be in X.XX format" required/>
          </div>

        </div>

        <div class="form-row">
          <div class="form-group col-md-8">
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

          <div class="form-group col-md-4">
            <label>Image File Name</label>
            <input type="text" name="ImageFileName" value="<?php echo $results['ImageFileName']?>" class="form-control">
          </div>
        </div>

          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-primary" value="Reset">
            <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./itemCRUD.php'">
          </div>
      </form>
  </div>
</body>
</html>