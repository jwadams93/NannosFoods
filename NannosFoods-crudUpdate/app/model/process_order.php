<?php
session_start();

//---DATABASE CONNECTION
require('../view/access_db.php');
connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

process_order();

//-------------------------------------------------------------
function process_order(){

  if (isset($_POST['vendorId'])){
    $vendorId = $_POST['vendorId'];
  }
  if (isset($_POST['storeId'])){
    $storeId = $_POST['storeId'];
  }

  //Debug Purposes
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  // //Initialize our index
  $i = 0;

  //Pull out arrays of values
  $items = $_POST['itemId'];
  $quantity = $_POST['itemQuantity'];
  $datetime = date('Y-m-d H:i:s');
  //echo ("::DateTime: $datetime::");
  $orderId = 0;

  //Length variable for ease of use
  $length = count($items);

  //Error Handling
  $errorStr = "::Error Placing Order:: ";
  $errorFound = false;
  $orderObjectCreated = false;

  //Pull out Item ID and Quantity
  //First time through the loop, create an ORDER table entry
  while($i < $length){
    //Pull out item and quantity to order
    $itemId = $items[$i];
    $itemOrderQuantity = $quantity[$i];
    echo (" ::Item Id: $itemId, Quantity: $itemOrderQuantity:: ");

    //Create entry in Return To Vendor table
    if($orderObjectCreated == false){
      echo(" !!FIRST TIME: CREATE ORDER ENTRY!! ");
      $createOrderQuery = "INSERT INTO `ORDER` (VendorId, StoreId, DateTimeOfOrder, Status) VALUES ('$vendorId', '$storeId', '$datetime', 'PENDING')";
      $createResult = mysql_query($createOrderQuery);

      //If any errors, set session message, redirect to process_return_ui
      if ($createResult == false){
        echo(" !!CREATE RESULT == FALSE!! ");
        $_SESSION['message'] = "Error Creating New Order Entry: ".mysql_errno.":".mysql_error;
        $_SESSION['msg_type'] = "danger";
        //header("location: ../view/process_order_ui.php");
      }
      else{
        echo(" !!CREATE RESULT == TRUE!! ");
        //Set flag to true to not create another entry in the database
        $orderObjectCreated = true;

        //Extract the ReturnToVendorId
        $orderIdQuery = mysql_query("SELECT OrderId FROM `ORDER` WHERE VendorId='$vendorId' AND StoreId='$storeId' AND DateTimeOfOrder='$datetime'");
        $orderIdResult = mysql_fetch_array($orderIdQuery);
        $orderId = $orderIdResult['OrderId'];

        echo("::Order Id: $orderId::");

        $_SESSION['$orderId'] = $orderId;
      }
    }

    //Check if we have a duplicate item
    $dupOrderCheck = mysql_query("SELECT * FROM `ORDERDETAIL` WHERE ItemId = '$itemId' AND OrderId = '$orderId'");

    if(mysql_num_rows($dupOrderCheck) > 0){

      $dupOrderResult = mysql_fetch_array($dupOrderCheck);
      $dupOrderItemQuantity = $dupOrderResult['QuantityOrdered'];
      $NewQuantity = $itemOrderQuantity + $dupOrderItemQuantity;

      //update quantity
      $orderDetailResult = mysql_query("UPDATE `ORDERDETAIL` SET QuantityOrdered = '$NewQuantity' WHERE ItemId = '$itemId' AND OrderId = '$orderId'");

    }else{

    $orderDetailQuery = "INSERT INTO `ORDERDETAIL` (OrderId, ItemId, QuantityOrdered) VALUES ('$orderId', '$itemId', '$itemOrderQuantity')";
    $orderDetailResult = mysql_query($orderDetailQuery);

    }
    if($orderDetailResult == false){
      alert("Error Inserting Order:\r\nItem Id: $itemId\r\nQuantity: $itemOrderQuantity");
    }

    //Increment index value
    $i++;
  }

  //Update Session variable
  if($errorFound){
    $_SESSION['message'] = $errorStr;
    $_SESSION['msg_type'] = "danger";
  }
  else{
    $_SESSION['message'] = "New Order processed successfully! Your Order's id is:". $_SESSION['$orderId'];
    $_SESSION['msg_type'] = "success";
  }
  if($errorFound){
    alert("::ERROR FOUND: $errorStr::");
  }
  else{
    alert("::NO ERROR: Items Processed Successfully!::");
  }

  //alert ("::SESSION ERROR MESSAGE: $_SESSION['message'], MESSAGE TYPE = $_SESSION[msg_type]::");
  header("location: ../view/process_order_ui.php");
}
//-------------------------------------------------------------
 function alert($msg) {
     echo "<script type='text/javascript'>alert('$msg');</script>";
 }
 //-------------------------------------------------------------
?>