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


  if((isset($_POST['returnSearch'])) && ((isset($_POST['startD']))&&!empty($_POST['startD']))){

      $startD = date("Y-m-d h:i:s", strtotime($_POST['startD']));

      if((isset($_POST['endD']))&&!empty($_POST['endD'])){
        $endD = date("Y-m-d h:i:s", strtotime($_POST['endD']));
      }
      else{
        $endD = date('Y-m-d h:i:s', time());
      }

      $returnedQuery = mysql_query("SELECT * FROM RETURNTOVENDOR RTV, RETURNTOVENDORDETAIL RTVD, VENDOR V, RETAILSTORE RS, INVENTORYITEM I WHERE
            RS.StoreId='$storeId' AND RTV.StoreId='$storeId' AND
            RTVD.ReturnToVendorId=RTV.ReturnToVendorId AND
            V.VendorId=RTV.VendorId AND I.ItemId=RTVD.ItemId AND
            RTV.DateTimeOfReturn >= '$startD' AND
            RTV.DateTimeOfReturn < '$endD'
            ORDER BY RTVD.QuantityReturned DESC LIMIT 10");
  }
  else{
    $returnedQuery = mysql_query("SELECT * FROM RETURNTOVENDOR RTV, RETURNTOVENDORDETAIL RTVD, VENDOR V, RETAILSTORE RS WHERE
          RS.StoreId='$storeId' AND RTV.StoreId='$storeId' AND RTVD.ReturnToVendorId=RTV.ReturnToVendorId AND V.VendorId=RTV.VendorId AND
          RTV.DateTimeOfReturn >= DATE_SUB(now(), INTERVAL 6 MONTH) ORDER BY RTVD.QuantityReturned DESC LIMIT 10");
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

  <form action="reports_returned.php" method="POST">
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
            <a class="nav-link" data-toggle="tab" href="#delivered" onclick="location='reports_delivered.php?sId=<?php echo $storeId ?>'">Delivered</a>
        </li>
        <li class="active">
            <a class="nav-link active" data-toggle="tab" href="#returned" onclick="location='reports_returned.php?sId=<?php echo $storeId ?>'">Returned</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div id="returned" class="tab-pane fade show active">
          <h3 class="mt-2" align="CENTER">Returned Items</h3>
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
