<?php

    require('../view/access_db.php');
    session_start();

    customerPurchase();

    function customerPurchase(){

        connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

        $ItemId = $_POST['ItemId'];
        $StoreId = $_POST['StoreId'];
        $CustomerId = $_POST['CustomerId'];
        $QuantityOrdered = $_POST['Quantity'];
        $DateTimeOfPurchase = date("Y-m-d H:i:s");
       
        $_SESSION['StoreId'] = $StoreId;


        $InvQuery = mysql_query("SELECT * FROM INVENTORY WHERE ItemId = '$ItemId' AND StoreId = '$StoreId'");

        $InvResult = mysql_fetch_array($InvQuery);

        $QuantityInStock = $InvResult['QuantityInStock'];

        $QuantityAfterOrder = $QuantityInStock - $QuantityOrdered;

        if($QuantityAfterOrder < 0 || $QuantityOrdered > $QuantityInStock){
            $_SESSION['message'] = "Sorry, we don't have the inventory to fulfill that order! Error number: ". mysql_errno();
            $_SESSION['msg_type'] = "danger";
        }else{
            $result = mysql_query("UPDATE INVENTORY SET QuantityInStock = '$QuantityAfterOrder' WHERE ItemId = '$ItemId' AND StoreId = '$StoreId'");

            $result2 = mysql_query("INSERT INTO CUSTOMERPURCHASE (CustomerId, ItemId, StoreId, QuantityPurchased, DateTimeOfPurchase) VALUES ('$CustomerId', '$ItemId', '$StoreId', '$QuantityOrdered', '$DateTimeOfPurchase')");
        }


        // SUCCESS/FAIL ALERT

        if($result == false || $result2 == false){
            $_SESSION['message'] = "Error completing order! Error number: ". mysql_errno();
            $_SESSION['msg_type'] = "danger";
        }else{
            $_SESSION['message'] = "Your purchase has been processed!";
            $_SESSION['msg_type'] = "success";
        }
        
    
        header("location: ../view/storeItemSelection.php");

    }

?>