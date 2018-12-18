<?php

    require('../view/access_db.php');
    session_start();

    process_delivery();

    function process_delivery(){

        connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

        // MARK ORDER AS DELIVERED, UPDATE TIME OF FULFILMENT

        $OrderId = $_POST['OrderId'];
        $OrderDate = date("Y-m-d H:i:s");

        $updatedItemArray = array();

        $query = "UPDATE `ORDER` SET
        `Status` = 'DELIVERED', DateTimeOfFulfilment = '$OrderDate'
        WHERE OrderId = '$OrderId'";

        htmlspecialchars($query);
        mysql_real_escape_string($query);

        $result = mysql_query($query);

        // UPDATE QUANTITY IN STOCK

        $OrderDetailQuery = mysql_query("SELECT * FROM ORDERDETAIL WHERE OrderId = '$OrderId'");

        // htmlspecialchars($OrderDetailQuery);
        // mysql_real_escape_string($OrderDetailQuery);

        while($row = mysql_fetch_array($OrderDetailQuery)){
            $QuantityOrdered = $row['QuantityOrdered'];
            $ThisOrderId = $row['OrderId'];
            $ThisItemId = $row['ItemId'];

            $getDesc = mysql_query("SELECT * FROM `INVENTORYITEM` WHERE ItemId = '$ThisItemId'");
            $ResultDesc = mysql_fetch_array($getDesc);
            $ThisItemDesc = $ResultDesc['Description'];

            $getStoreId = mysql_query("SELECT StoreId FROM `ORDER` WHERE OrderId = '$ThisOrderId'");
            $store = mysql_fetch_array($getStoreId);
            $ThisStoreId = $store['StoreId'];

            $dupOrderCheck = mysql_query("SELECT * FROM `INVENTORY` WHERE StoreId = '$ThisStoreId' AND ItemId = '$ThisItemId'");

            if(mysql_num_rows($dupOrderCheck) > 0){

                $dupOrderResult = mysql_fetch_array($dupOrderCheck);
                $dupOrderItemQuantity = $dupOrderResult['QuantityInStock'];
                $NewQuantity = $QuantityOrdered + $dupOrderItemQuantity;

                $InventoryQuery = "UPDATE `INVENTORY` SET QuantityInStock = '$NewQuantity' WHERE ItemId = '$ThisItemId' AND StoreId = '$ThisStoreId'";

            // $InventoryQuery = "UPDATE `INVENTORY`
            //                     LEFT JOIN `ORDER`
            //                         ON `INVENTORY`.StoreId =`ORDER`.StoreId
            //                         SET `INVENTORY`.QuantityInStock = '$QuantityOrdered' 
            //                     WHERE `INVENTORY`.ItemId = '$ThisItemId'";

                $result2 = mysql_query($InventoryQuery);

            //Add the key value pair of the updated item's id, and the new quantitiy in stock
                $updatedItemArray[$ThisItemDesc] = $QuantityOrdered;
            }else{
                $result2 = mysql_query("INSERT INTO INVENTORY (StoreId, ItemId, QuantityInStock) VALUES ('$ThisStoreId', '$ThisItemId', '$QuantityOrdered')");

                $updatedItemArray[$ThisItemDesc] = $QuantityOrdered;
            }
        }

        //Pass the updated item array into the session.
        $_SESSION['updatedItemArray'] = $updatedItemArray;

        // SUCCESS/FAIL ALERT

        if($result == false || $result2 == false){
            $_SESSION['message'] = "Error Processing Delivery! Error number: ". mysql_errno();
            $_SESSION['msg_type'] = "danger";
        }else{
            $_SESSION['message'] = "Your Delivery has been processed!";
            $_SESSION['msg_type'] = "success";
        }
        
    
        header("location: ../view/process_delivery_ui.php");

    }

?>