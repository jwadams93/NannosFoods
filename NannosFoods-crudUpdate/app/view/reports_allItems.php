<?php
  session_start();

  require('./access_db.php');

  connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

  $storeId='xxx';
  $storeName='Please Choose A Store';
  $storeCode='xxx';

  if(isset($_GET['sId'])){
    $storeId = $_GET['sId'];
    $query = mysql_query("SELECT StoreName, StoreCode FROM RETAILSTORE WHERE StoreId='$storeId'");
    $result = mysql_fetch_assoc($query);
    $storeName = $result['StoreName'];
    $storeCode = $result['StoreCode'];
  }

  if(isset($_POST['storeId'])){
    $storeId = $_POST['storeId'];
    $query = mysql_query("SELECT StoreName, StoreCode FROM RETAILSTORE WHERE StoreId='$storeId'");
    $result = mysql_fetch_assoc($query);
    $storeName = $result['StoreName'];
    $storeCode = $result['StoreCode'];
  }

  $storeQuery = mysql_query("SELECT * FROM RETAILSTORE");
  $all_items = mysql_query("SELECT * FROM INVENTORY I, INVENTORYITEM IT WHERE I.StoreId='$storeId' AND I.ItemId=IT.ItemId") or die(mysql_error());

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
  <link rel="stylesheet" href="./style/style.css">
  <title>Store Reports | Nanno's Foods</title>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

  <script type="text/javascript">
  $('#myTab a[href="#allItems"]').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
  $('#myTab a[href="#overstocked"]').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
  $('#myTab a[href="#delivered"]').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
  </script>
</head>

<body>
<?php require('./header/header.php'); ?>

<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">

  <form class="form-inline my-2 my-lg-0" action="reports_allItems.php" method="POST">
    <h3 align="center">Store Reports | Nanno's Foods</h3>
    <div class="container" style="padding-top:30px;">
      <div class="form-group">
        <p class="mr-2">Store Code | Name</p>
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

    <div class="container">
      <!-- Navigation Pane -->
      <ul class="nav nav-tabs nav-justified" style="padding-bottom:30px;">
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#overstocked" onclick="location='reports_overstocked.php?sId=<?php echo $storeId ?>'">Overstocked</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#allItems" onclick="location='reports_allItems.php?sId=<?php echo $storeId ?>'">All Inventory</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#delivered" onclick="location='reports_delivered.php?sId=<?php echo $storeId ?>'">Delivered</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#returned" onclick="location='reports_returned.php?sId=<?php echo $storeId ?>'">Returned</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div id="allItems" class="tab-pane fade show active">
          <h3 class="my-3" align="CENTER">All Inventory Items</h3>
          <table class="table" style="padding-top:50px;">
            <thead>
              <tr>
                <th>Item Id</th>
                <th>Description</th>
                <th>Size</th>
  						  <th>Division</th>
  						  <th>Department</th>
  						  <th>Category</th>
  						  <th>Item Cost</th>
  						  <th>Item Retail</th>
  						  <th>VendorId</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
            <?php
                while($allItemsResults = mysql_fetch_array($all_items)){
                echo "<tr>"
                        ."<td>".$allItemsResults['ItemId']."</td>"
                        ."<td>".$allItemsResults['Description']."</td>"
                        ."<td>".$allItemsResults['Size']."</td>"
                        ."<td>".$allItemsResults['Division']."</td>"
        							  ."<td>".$allItemsResults['Department']."</td>"
        							  ."<td>".$allItemsResults['Category']."</td>"
        							  ."<td>".$allItemsResults['ItemCost']."</td>"
        							  ."<td>".$allItemsResults['ItemRetail']."</td>"
        							  ."<td>".$allItemsResults['VendorId']."</td>"
                        ."<td>".$allItemsResults['QuantityInStock']."</td>"
        						  ."</tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </form>
</div>
</body>
</html>
