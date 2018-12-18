<?php

    require('../view/access_db.php');
    session_start();

    find_order();

    function find_order(){

        connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

        $OrderId = $_POST['OrderId'];
        $OrderQuere = "SELECT * FROM ORDERDETAIL WHERE OrderId = '$OrderId'";
        $vendorId = mysql_query("SELECT VendorId FROM `ORDER` WHERE OrderId = '$OrderId'");
		$OrderItemArray = array();
		$result = mysql_query($OrderQuery);
		$vendorItems = mysql_query("SELECT ItemId FROM INVENTORYITEMS WHERE VendorId = '$vendorId'");
        $vendorItemsArray = array();
		
		while($row = mysql_fetch_array($OrderQuery)){
            $QuantityOrdered = $row['QuantityOrdered'];
            $ThisItemName = $row['ItemId'];

            //Add the key value pair of the updated item's id, and the new quantitiy in stock
            $OrderItemArray[$ThisItemName] = $QuantityOrdered;
        }
		while($row = mysql_fetch_array()){
			$VenItemId = $row['ItemId'];
			$itemName = $row['Description'];
			$vendorItemsArray[$VenItemId] = $itemName;
		}
        //Pass the updated item array into the session.
        $_SESSION['orderItemArray'] = $OrderItemArray;
		$_SESSION['vendorItemsArray'] = $vendorItemsArray;
		
		
        // SUCCESS/FAIL ALERT

        if($result == false){
            $_SESSION['message'] = "Error Retrieving Items from OrderId: ". mysql_errno();
            $_SESSION['msg_type'] = "danger";
        }else{
			$_SESSION['displayForm'] = false;
			
        }
        
        header("location: ../view/add_item_to_order_ui.php");
		
    }

?>