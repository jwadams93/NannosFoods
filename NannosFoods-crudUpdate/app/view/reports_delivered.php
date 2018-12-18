<?php
  session_start();

  require('./access_db.php');

  connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

  $storeId='xxx';
  $storeName='Please Choose A Store';
  $storeCode='xxx';

  $storeQuery = mysql_query("SELECT * FROM RETAILSTORE");

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

  if((isset($_POST['deliveredSearch'])) && ((isset($_POST['startD']))&&!empty($_POST['startD']))){

      $startD = date("Y-m-d h:i:s", strtotime($_POST['startD']));

      if((isset($_POST['endD']))&&!empty($_POST['endD'])){
        $endD = date("Y-m-d h:i:s", strtotime($_POST['endD']));
      }
      else{
        $endD = date('Y-m-d h:i:s', time());
      }

      $deliveredQuery = mysql_query("SELECT * FROM `ORDER` O, ORDERDETAIL OD, INVENTORYITEM I, VENDOR V WHERE
        O.StoreId='$storeId' AND O.OrderId=OD.OrderId AND OD.ItemId=I.ItemId AND O.VendorId=V.VendorId AND O.Status='DELIVERED' AND
        O.DateTimeOfFulfilment >= '$startD' AND
        O.DateTimeOfFulfilment < '$endD'
        ORDER BY O.DateTimeOfFulfilment DESC");
  }
  else{
    $deliveredQuery = mysql_query("SELECT * FROM `ORDER` O, ORDERDETAIL OD, INVENTORYITEM I, VENDOR V WHERE
          O.StoreId='$storeId' AND O.OrderId=OD.OrderId AND OD.ItemId=I.ItemId AND O.VendorId=V.VendorId AND O.Status='DELIVERED' AND
          O.DateTimeOfFulfilment >= DATE_SUB(now(), INTERVAL 1 WEEK) ORDER BY O.DateTimeOfFulfilment DESC");
  }
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

</head>

<body>

<?php require('./header/header.php'); ?>

<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">

  <form class="form-inline my-2 my-lg-0" action="reports_delivered.php" method="POST">
    <input type="hidden" name="storeId" id="storeId" value="<?php echo $storeId ?>"/>

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
            <a class="nav-link" data-toggle="tab" href="#allItems" onclick="location='reports_allItems.php?sId=<?php echo $storeId ?>'">All Inventory</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#delivered" onclick="location='reports_delivered.php?sId=<?php echo $storeId ?>'">Delivered</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#returned" onclick="location='reports_returned.php?sId=<?php echo $storeId ?>'">Returned</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div id="delivered" class="tab-pane fade show active">
          <h3 class="mt-2" align="CENTER">Delivered Items</h3>
          <div class="container">
            <p>Search by start date and end date</p>

            <div class="form-row form-inline" style="padding-bottom: 30px;">
              <div class="form-group col-lg-3">
                  <label class="mr-2">Start Date</label>
                  <input class="form-control mr-sm-2" type="date" name="startD" value="<?php echo $startD ?>">
              </div>
              <div class="form-group col-lg-3">
                  <label class="mr-2">End Date</label>
                  <input class="form-control mr-sm-2" type="date" name="endD" value="<?php echo $endD ?>">
              </div>
              <div class="form-group col-lg-12 mt-3">
                  <button type="submit" name="deliveredSearch" class="btn btn-outline-primary my-2 my-sm-0">Search</button>
              </div>
            </div>
            <table class="table">
            <?php
                if(mysql_num_rows($deliveredQuery) > 0 ){ // if one or more rows are returned do following
                    echo "<thead>
                            <tr>
                              <th>Vendor Name</th>
                              <th>Item ID</th>
                              <th>Description</th>
                              <th>Quantity Ordered</th>
                              <th>Date of Delivery</th>
                            </tr>
                          </thead>
                          <tbody>";

                    while($deliveredResults = mysql_fetch_array($deliveredQuery)){
                    // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                        echo "<tr>"."<td>".$deliveredResults['VendorName']."</td>"
                                  ."<td>".$deliveredResults['ItemId']."</td>"
                                  ."<td>".$deliveredResults['Description']."</td>"
                                  ."<td>".$deliveredResults['QuantityOrdered']."</td>"
                                  ."<td>".$deliveredResults['DateTimeOfFulfilment']."</td>"."</tr>";
                    }
                    echo "</tbody>";
                }
                else{ // if there is no matching rows do following
                  echo '<center>
                  <br/><br/>
                  <h5>Record not found!</h5>
                  </center>';
                }
            ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</body>
</html>
