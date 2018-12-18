<?php
session_start();

//---DATABASE CONNECTION
require('../view/access_db.php');

connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

process_returns();

//-------------------------------------------------------------
function process_returns(){

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
  echo ("::DateTime: $datetime::");
  $returnId = 0;

  //Length variable for ease of use
  $length = count($items);

  //Error Handling
  $errorStr = "Error Returning The Following Items:Return Quantity Can Not Exceed Available Stock: ";
  $errorFound = false;
  $returnObjectCreated = false;

  //Pull out Item ID and Quantity
  //Check if quantity is greater than value in INVENTORYITEM table
  //If quantity > item quantity, add error to $_SESSION['error_string']
  //If not, proceed with the request
  while($i < $length){
    $itemId = $items[$i];
    $itemReturnQuantity = $quantity[$i];

    $inventoryQuery = mysql_query("SELECT QuantityInStock FROM INVENTORY WHERE ItemId='$itemId' AND StoreId='$storeId'");
    $inventoryResult = mysql_fetch_array($inventoryQuery);
    $inStock = $inventoryResult['QuantityInStock'];

    //If Quantity is valid
    if ($inStock >= $itemReturnQuantity){
        echo (":::ItemID: $itemId, In Stock: $inStock, Return Quantity: $itemReturnQuantity:::");

      //Create entry in Return To Vendor table
      if($returnObjectCreated == false){
        $createReturnQuery = "INSERT INTO RETURNTOVENDOR (VendorId, StoreId, DateTimeOfReturn) VALUES ('$vendorId', '$storeId', '$datetime')";
        $createResult = mysql_query($createReturnQuery);

        //If any errors, set session message, redirect to process_return_ui
        if ($createResult == false){
          $_SESSION['message'] = "Error Creating New Return To Vendor Entry: ".mysql_errno.":".mysql_error;
          $_SESSION['msg_type'] = "danger";
          header("location: ../view/process_return_ui.php");
        }
        else{
          //Set flag to true to not create another entry in the database
          $returnObjectCreated = true;

          //Extract the ReturnToVendorId
          $rtvIdQuery = mysql_query("SELECT ReturnToVendorId FROM RETURNTOVENDOR WHERE VendorId='$vendorId' AND StoreId='$storeId' AND DateTimeOfReturn='$datetime'");
          $rtvIdResult = mysql_fetch_array($rtvIdQuery);
          $returnId = $rtvIdResult['ReturnToVendorId'];

          echo("::ReturnToVendorId: $returnId::");
        }
      }


      $newQuantity = $inStock - $itemReturnQuantity;
      $updateStmt = "UPDATE `INVENTORY` SET QuantityInStock='$newQuantity' WHERE ItemId='$itemId' AND StoreId='$storeId'";
      $updateResult = mysql_query($updateStmt);
      if($updateResult == false){
        alert("Error Updating Database:\r\nItem Id: $itemId\r\nQuantity: $itemReturnQuantity");
      }

      $returnToVendorDetailQuery = "INSERT INTO RETURNTOVENDORDETAIL (ReturnToVendorId, ItemId, QuantityReturned) VALUES ('$returnId', '$itemId', '$itemReturnQuantity')";
      $insertReturnDetailResult = mysql_query($returnToVendorDetailQuery);
      if($insertReturnDetailResult == false){
        alert("Error Inserting Return:\r\nItem Id: $itemId\r\nQuantity: $itemReturnQuantity");
      }
    }

    //Invalid Quantity
    else{
      $errorQuery = mysql_query("SELECT * FROM INVENTORYITEM WHERE ItemId='$itemId'");
      $errorResult = mysql_fetch_array($errorQuery);
      $itemDesc = $errorResult['Description'];
      $itemError = "::$itemId | $itemDesc::";
      echo ("::Item Error: $itemError::");
      $errorStr .= $itemError;
      $errorFound = true;
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
    $_SESSION['message'] = "All returns processed successfully!";
    $_SESSION['msg_type'] = "success";
  }

  header("location: ../view/process_return_ui.php");
}
//-------------------------------------------------------------
 function alert($msg) {
     echo "<script type='text/javascript'>alert('$msg');</script>";
 }
 //-------------------------------------------------------------
?>