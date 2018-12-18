<?php
session_start();

//---DATABASE CONNECTION
require('../view/access_db.php');
connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

process_order();

//-------------------------------------------------------------
function process_order(){

  //Debug Purposes
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  // //Initialize our index
  $i = 0;

  //Pull out arrays of values
  $orderId = $_POST['orderId'];
  $items = $_POST['itemId'];
  $quantity = $_POST['itemQuantity'];

  //Length variable for ease of use
  $length = count($items);

  //Error Handling
  $errorStr = ":: Error Adding Items :  ";
  $errorFound = false;

  //Pull out Item ID and Quantity
  //First time through the loop, create an ORDER table entry
  while($i < $length){
    //Pull out item and quantity to order
    $itemId = $items[$i];
    $itemOrderQuantity = $quantity[$i];
    echo (" ::Item Id: $itemId, Quantity: $itemOrderQuantity:: ");

    $orderDetailQuery = "INSERT INTO ORDERDETAIL (OrderId, ItemId, QuantityOrdered) VALUES ('$orderId', '$itemId', '$itemOrderQuantity')";
    echo $orderDetailQuery;
    $orderDetailResult = mysql_query($orderDetailQuery);
    if($orderDetailResult == false){
      $errorStr .= ": Item Id: $itemId, Quantity: $itemOrderQuantity :";
      $errorFound = True;
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
    $_SESSION['message'] = "All orders processed successfully!";
    $_SESSION['msg_type'] = "success";
  }

  header("location: ../view/add_item_order_ui.php");
}
//-------------------------------------------------------------
 function alert($msg) {
     echo "<script type='text/javascript'>alert('$msg');</script>";
 }
 //-------------------------------------------------------------
?>