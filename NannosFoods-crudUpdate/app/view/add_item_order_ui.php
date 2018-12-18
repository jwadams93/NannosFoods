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
  <title>Add Items to Existing Order | Nanno's Food</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
    //$(#showOrder).hide();
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
    $vendorName='xxx';
    $storeId='xxx';
    $storeName='xxx';
    $storeCode='xxx';

    //---DATABASE CONNECTION
     require('../view/access_db.php');

     connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

     if(isset($_POST['orderId']) && !empty($_POST['orderId'])){
       //PULL OUT ORDER ID
       $orderId = $_POST['orderId'];
       $query = mysql_query("SELECT * FROM `ORDER` WHERE OrderId='$orderId'");
       $result = mysql_fetch_assoc($query);

       if($result == false){
         $_SESSION['message'] = "Invalid Order Id, Please Try Again";
         $_SESSION['msg_type'] = "warning"; ?>
         <script type="text/javascript">
           //JQUERY CODE HERE TO HIDE DIV, SINCE ORDER ID IS SET
           $("#orderIdSearch").show();
           $("#showOrder").hide();
         </script>
         <?php
         header("location:./add_item_order_ui.php");
       }
       else{ ?>
         <script type="text/javascript">
         //JQUERY CODE HERE TO HIDE DIV, SINCE ORDER ID IS SET
         $("#orderIdSearch").hide();
         $("#showOrder").show();
         </script>

         <?php
         //SET VENDOR AND STORE IDs
         $vendorId = $result['VendorId'];
         $storeId = $result['StoreId'];

         //SET VENDOR NAME
         $query = mysql_query("SELECT VendorName FROM VENDOR WHERE VendorId='$vendorId'");
         $result = mysql_fetch_assoc($query);
         $vendorName = $result['VendorName'];

         //SET STORE NAME
         $query = mysql_query("SELECT * FROM RETAILSTORE WHERE StoreId='$storeId'");
         $result = mysql_fetch_assoc($query);
         $storeName = $result['StoreName'];
         $storeCode = $result['StoreCode'];
      }
     }
     else{ ?>
       <script type="text/javascript">
         //JQUERY CODE HERE TO HIDE DIV, SINCE ORDER ID IS SET
         $("#orderIdSearch").show();
         $("#showOrder").hide();
       </script>
       <?php
     }


    //Gather Item Data
    $itemQuery= mysql_query("SELECT * FROM INVENTORYITEM WHERE VendorId='$vendorId'");
    $currentOrderQuery = mysql_query("SELECT * FROM ORDERDETAIL WHERE OrderId='$orderId'");
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

<!-- <div class="container" id="orderIdSearch"> -->
  <form action="add_item_order_ui.php" class="form-inline my-2 my-lg-0" method="POST">
    <div class="container" style="background-color: #EEEEEE">
      <div class="container" style="padding-top:20px;">
        <div style="padding-bottom: 15px;">
          <h2>Enter an Order Id</h2>
        </div>
        <div class="form-group">
          <label>Order Id:</label> &nbsp;
          <input type="text" class="form-control mr-sm-2" name="orderId" id="orderId" placeholder="Please Enter Order Id"
            pattern="^\d+$" title="Order Id Must Be A Number"/>
          <button class="btn btn-outline-primary my-2 my-sm-0" onclick="this.form.submit()">Search Order</button>
        </div>
      </div>
    </div>
  </form>
<!-- </div> -->

<!-- <div class="container" id="showOrder"> -->

    <div class="card">
      <div class="card-body">
        <ul class="list-group bg-light list-group-flush">
          <li class="list-group-item"> Order Id: <?php echo ($orderId); ?></li>
          <li class="list-group-item"> Vendor: <?php echo ($vendorName); ?></li>
          <li class="list-group-item"> Order Id: <?php echo ($storeCode."|".$storeName); ?></li>
        </ul>
      </div>
    </div>

<!-- </div> -->

<div class="container" id="itemCards">
  <div class="card">
    <div class="card-header">
      Current Order
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        <?php
          while($orderResult = mysql_fetch_array($currentOrderQuery)){
            $currentItemId = $orderResult['ItemId'];
            $currentItemQuantity = $orderResult['QuantityOrdered'];
            $itemNameQuery= mysql_query("SELECT * FROM INVENTORYITEM WHERE ItemId='$currentItemId'");
            $itemNameResult = mysql_fetch_array($itemNameQuery);
            $currentItemName = $itemNameResult['Description'];
            echo "<li class='list-group-item'>";
            echo ($currentItemId." | ".$currentItemName." | Quantity: ".$currentItemQuantity);
            echo ("</li>");
          }
        ?>
      </ul>
    </div>
  </div>

  <div class="container" id="items">
    <div class="row" style="display: inline;">
        <h3 class="font-weight-light">Add Items to Order</h3>
        <p style="padding-top: 20px;">
          <button id="addItemBoxButton" class="btn btn-primary">Add Another Item</button>
        <p>
    </div>
  </div>

  <form action="../model/process_add_item_order.php" method="POST">
    <div class="container">
      <p style="padding-bottom: 20px;">
        <button type="submit" class="btn btn-warning">Process Item Addition</button>
      </p>
    </div>
    <input type="hidden" id="orderId" name="orderId" value="<?php echo $orderId ?>"/>

    <div id="itemContainer" class="container justify-content-center">
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
    </div>
  </form>
</div>

</body>
</html>