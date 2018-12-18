<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- font awesome icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="./style/style.css">
  <title>Process A Return | Nanno's Food</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
      var count=1;
      $("#addItemBoxButton").click(function(){
        if(count==0){
          $("#itemForm").show();

          count++;
        }
        else{
          $("#itemForm").clone(true).appendTo("#row");

          count++;
        }
      });
      $(".glyphicon-remove").click(function () {
        if(count>1){
          $(this).closest("#itemForm").remove();

          count--;
        }
        else{
          $(this).closest("#itemForm").hide();
          count--;
        }
      });
  });
  </script>
</head>
<body>

<?php require_once('./header/header.php'); ?>

  <?php
    $vendorId='xxx';
    $vendorName='Please Choose A Vendor';
    $storeId='xxx';
    $storeName='Please Choose A Store';
    $storeCode='xxx';

    //---DATABASE CONNECTION
     require('../view/access_db.php');

     connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

     if(isset($_POST['vendorId']) && !empty($_POST['vendorId'])){
       $vendorId = $_POST['vendorId'];
       $query = mysql_query("SELECT VendorName FROM VENDOR WHERE VendorId='$vendorId'");
       $result = mysql_fetch_assoc($query);
       $vendorName = $result['VendorName'];
     }
     if(isset($_POST['storeId'])){
       $storeId = $_POST['storeId'];
       $query = mysql_query("SELECT StoreName, StoreCode FROM RETAILSTORE WHERE StoreId='$storeId'");
       $result = mysql_fetch_assoc($query);
       $storeName = $result['StoreName'];
       $storeCode = $result['StoreCode'];
     }

    //Gather Item Data
    $itemQuery= mysql_query("SELECT * FROM INVENTORYITEM WHERE VendorId='$vendorId'");
    $activeVendorQuery= mysql_query("SELECT * FROM VENDOR WHERE ActiveStatus = 'active'");
    $storeQuery = mysql_query("SELECT * FROM RETAILSTORE");
  ?>

  <!-- Code To Display Relevant Session Message -->
  <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?=$_SESSION['msg_type']?>">
          <?php
                  echo $_SESSION['message'];
                  unset($_SESSION['message']);
          ?>
      </div>
  <?php endif ?>

<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">

<form action="process_return_ui.php" method="POST">
  <div style="background-color: #EEEEEE">
    <div class="container" style="padding-top:20px;">
      <div style="padding-bottom: 15px;">
        <h2>Process a Return</h2>
      </div>
      <div class="form-group">
          <label>Vendor</label>
          <select name="vendorId" id="vendorId" class="custom-select form-control" onchange="this.form.submit()" required>
            <?php
              echo "<option value='".$vendorId."'>";
              echo $vendorName;
              echo '</option>';
                while($vendor_result = mysql_fetch_array($activeVendorQuery)){
                  echo "<option value='".$vendor_result['VendorId']."'>";
                  echo $vendor_result['VendorName'];
                  echo '</option>';
                }
            ?>
          </select>
      </div>

      <div class="form-group">
        <label>Store ID | Name</label>
        <select name="storeId" id="storeId" class="custom-select form-control mb-4" onchange="this.form.submit()" required>
          <?php
                echo "<option value='".$storeId."'>";
                echo $storeCode." | ".$storeName;
                echo "</option>";
              while($store_result = mysql_fetch_array($storeQuery)){
                echo "<option value='".$store_result['StoreId']."'>";
                echo $store_result['StoreCode'] . " | " . $store_result['StoreName'];
                echo '</option>';
              }
          ?>
        </select>
      </div>
    </div>
  </div>
</form>

<!-- <div class="container" id="items"> -->
  <div class="row" style="display: inline;">
      <h3 class="font-weight-light">Items to Return</h3>
      <p style="padding-top: 20px;">
        <button id="addItemBoxButton" class="btn btn-primary">Add Another Item</button>
      <p>
  </div>
<!-- </div> -->

<form action="../model/process_return.php" method="POST" id="fullItemForm">
  <!-- <div class="container"> -->
    <p style="padding-bottom: 20px;">
      <button type="submit" class="btn btn-warning">Process Return</button>
    </p>
  <!-- </div> -->
<input type="hidden" id="vendorId" name="vendorId" value="<?php echo $vendorId ?>"/>
<input type="hidden" id="storeId" name="storeId" value="<?php echo $storeId ?>"/>

  <!-- <div id="itemContainer" class="container justify-content-center"> -->
    <div id="row" class="row">
      <div id="itemForm" class="card col-sm-4 col-lg-3 mr-3 shadow-sm p-3 mb-5 bg-white rounded">
          <div class="card-body p-0">
            <ul class="list-group bg-light">

              <li class="list-group-item">
                <p style="font-weight: bold">Item Id | Description
                  <span style="float: right;" class="glyphicon glyphicon-remove"><i class="fas fa-times"></i></span>
                </p>
              </li>

              <li class="list-group-item">
                <select class="form-control" name="itemId[]" required>
                  <?php
                      echo "<option value=''></option>";
                    while($item_result = mysql_fetch_array($itemQuery)){
                      echo "<option value='".$item_result['ItemId']."'>";
                      echo $item_result['ItemId'] . " | " . $item_result['Description'];
                      echo '</option>';
                    }
                  ?>
                </select>
              </li>

              <li class="list-group-item">
                <p style="font-weight: bold">Quantity</p>
              </li>

              <li class="list-group-item">
                <input class="form-control" name="itemQuantity[]" type="number" min='1'
                  max='250' step='1' pattern="^[0-9]+$" title="Entry must be a whole number" required />
              </li>

            </ul>
          </div>
      </div>
    </div>
  <!-- </div> -->
</form>
</div>

</body>
</html>