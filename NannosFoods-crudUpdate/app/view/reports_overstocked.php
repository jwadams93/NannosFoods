<?php
  session_start();

  require('./access_db.php');

  connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

  $storeId='xxx';
  $storeName='Please Choose A Store';
  $storeCode='xxx';
  $threshold=0;

  if(isset($_POST['threshold'])){
    $threshold = $_POST['threshold'];
  }

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
  #$overstockQuery = mysql_query("");


  $overstockQuery = mysql_query("SELECT * FROM INVENTORY I, INVENTORYITEM IT WHERE I.StoreId='$storeId' AND I.QuantityInStock>$threshold AND I.ItemId=IT.ItemId");

  if(isset($_POST['deliveredSearch'])){
    $startDate = $_POST['deliveredStartDate'];
    if(isset($_POST['delieveredEndDate'])){
      $endDate = $_POST['deliveredEndDate'];
    }
    else {
      $endDate = date('Y-m-d H:i:s');
    }


    $deliveredQuery = mysql_query("SELECT * FROM ORDER O, ORDERDETAIL OD WHERE
                                    O.StoreId='$storeId' AND
                                    O.OrderId=OD.OrderId AND
                                    O.Status='DELIVERED' AND
                                    O.DateTimeOfFulfilment >= DATE_SUB(now(), INTERVAL 1 WEEK) ORDER BY O.DateTimeOfFulfilment DESC");

  }
  else{
    $deliveredQuery = mysql_query("SELECT * FROM ORDER O, ORDERDETAIL OD WHERE
                                    O.StoreId='$storeId' AND
                                    O.OrderId=OD.OrderId AND
                                    O.Status='DELIVERED' AND
                                    O.DateTimeOfFulfilment >= DATE_SUB(now(), INTERVAL 1 WEEK) ORDER BY O.DateTimeOfFulfilment DESC");
  }


  $returnedQuery = mysql_query("SELECT * FROM RETURNTOVENDOR RTV, RETURNTOVENDORDETAIL RTVD, VENDOR V, RETAILSTORE RS WHERE
        RS.StoreId='$storeId' AND RTV.StoreId='$storeId' AND RTVD.ReturnToVendorId=RTV.ReturnToVendorId AND V.VendorId=RTV.VendorId WHERE
        WHERE RTV.DateTimeOfReturn >= DATE_SUB(now(), INTERVAL 6 MONTH) ORDER BY RTVD.QuantityReturned DESC LIMIT 10");

  if(isset($_POST['returnSearch']) && isset($_POST['startD'])){

      $startD = $_POST['startD'];
      $endD = $_POST['endD'];
      if(!isset($endD)){
        $endD = date('Y-m-d H:i:s');
      }

      $returnedQuery = mysql_query("SELECT * FROM RETURNTOVENDOR RTV, RETURNTOVENDORDETAIL RTVD, VENDOR V, RETAILSTORE RS, INVENTORYITEM I WHERE
            RS.StoreId='$storeId' AND RTV.StoreId='$storeId' AND RTVD.ReturnToVendorId=RTV.ReturnToVendorId AND V.VendorId=RTV.VendorId AND I.ItemId=RTVD.ItemId WHERE
            RTV.DateTimeOfReturn BETWEEN CAST($startD AS DATE) AND CAST($endD AS DATE)
            ORDER BY RTVD.QuantityReturned DESC LIMIT 10");


      // $returnedQuery = mysql_query("SELECT * FROM RETURNTOVENDOR AS T1
      //       INNER JOIN
      //       RETURNTOVENDORDETAIL AS T2 ON T1.ReturnToVendorId = T2.ReturnToVendorId
      //       INNER JOIN
      //       VENDOR AS T3 ON T1.VendorId = T3.VendorId
      //       INNER JOIN
      //       RETAILSTORE AS T4 ON T1.StoreId = T4.StoreId
      //       WHERE T1.DateTimeOfReturn BETWEEN '" . $startD . "' AND '" . $endD ."' ORDER BY T2.QuantityReturned DESC LIMIT 10");
  }
  else{
    $returnedQuery = mysql_query("SELECT * FROM RETURNTOVENDOR RTV, RETURNTOVENDORDETAIL RTVD, VENDOR V, RETAILSTORE RS WHERE
          RS.StoreId='$storeId' AND RTV.StoreId='$storeId' AND RTVD.ReturnToVendorId=RTV.ReturnToVendorId AND V.VendorId=RTV.VendorId WHERE
          WHERE RTV.DateTimeOfReturn >= DATE_SUB(now(), INTERVAL 6 MONTH) ORDER BY RTVD.QuantityReturned DESC LIMIT 10");
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
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

  <form class="form-inline my-2 my-lg-0" action="reports_overstocked.php" method="POST">

    <center><h3>Store Reports | Nanno's Foods</h3></center>
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
              <a class="nav-link active" data-toggle="tab" href="#overstocked" onclick="location='reports_overstocked.php?sId=<?php echo $storeId ?>'">Overstocked</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#allItems" onclick="location='reports_allItems.php?sId=<?php echo $storeId ?>'">All Inventory</a>
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
          <div id="overstocked" class="tab-pane fade show active">
            <center><h3 class="mt-3">Overstocked Items Report</h3></center>

            <div class="container" style="padding-bottom:50px;">
              <p>Enter Quantity</p>
              <input class="form-control mr-sm-2" type="text" name="threshold" id="threshold" value="<?php echo $threshold ?>">
              <button type="submit" class="btn btn-outline-primary my-2 my-sm-0" onclick="this.form.submit()">Search</button>
            </div>
            <table class="table">
            <?php

              if(mysql_num_rows($overstockQuery) > 0){ // if one or more rows are returned do following
            ?>
                <thead>
                  <tr>
                    <th>Item Id</th>
                    <th>Description</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
            <?php
                while($overstockResults = mysql_fetch_array($overstockQuery)){
                echo "<tr>"
                      ."<td>".$overstockResults['ItemId']."</td>"
                      ."<td>".$overstockResults['Description']."</td>"
                      ."<td>".$overstockResults['QuantityInStock']."</td>"
                    ."</tr>";
                }

                echo "</tbody>";
                }
                else{ // if there is no matching rows do following
                  echo '<center>
                    <br/><br/>
                    <h5>No Items Overstocked!</h5>
                  </center>';
                }
            ?>
            </table>
          </div>

          <div id="allItems" class="tab-pane fade">
            <h3 align="CENTER">All Inventory Items</h3>
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

          <div id="delivered" class="tab-pane fade">
            <input type="date" name="startDate" id="startDate"
            <input type="submit"
            <p>This is the delivered items tab</p>
          </div>
          <div id="returned" class="tab-pane fade">
            <div class="container">
              <p>Search by start date and end date</p>
              <p>Start Date Selected: <?php echo $startD ?></p>
              <p>End Date Selected: <?php echo $endD ?> </p>
              <p>Store Id: <?php echo $storeId ?> </p>

              <div class="row justify-content-center">
                    <label>Start Date</label>
                    <input type="date" name="startD">
                    <label>End Date</label>
                    <input type="date" name="endD">
                    <input type="submit" name="returnSearch" class="btn btn-primary" value="Search">
              </div>
              <table class="table">
              <?php
                  if(mysql_num_rows($returnedQuery) > 0 ){ // if one or more rows are returned do following
                      echo "<thead>
                              <tr>
                                <th>Vendor Name</th>
                                <th>Store Name</th>
                                <th>Date of Return</th>
                                <th>Item ID</th>
                                <th>Description</th>
                                <th>Quantity Returned</th>
                              </tr>
                            </thead>
                            <tbody>";

                      while($returnedResults = mysql_fetch_array($returnedQuery)){
                      // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                          echo "<tr>"."<td>".$returnedResults['VendorName']."</td>"
                                    ."<td>".$returnedResults['StoreName']."</td>"
                                    ."<td>".$returnedResults['DateTimeOfReturn']."</td>"
                                    ."<td>".$returnedResults['ItemId']."</td>"
                                    ."<td>".$returnedResults['Description']."</td>"
                                    ."<td>".$returnedResults['QuantityReturned']."</td>"."</tr>";
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
