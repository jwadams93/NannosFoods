<?php
    require('./access_db.php');
    session_start();

    fetchTableData();

    function fetchTableData(){

        $conn = connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

        if(isset($_SESSION['VendorId'])){
            $VendorId = $_SESSION['VendorId'];
        }

        $resultPending = mysql_query("SELECT * FROM `ORDER` WHERE `ORDER`.VendorId = '$VendorId' AND `ORDER`.`Status` = 'PENDING' ORDER BY `ORDER`.`DateTimeOfOrder`") or die(mysql_error());

        $resultDelivered = mysql_query("SELECT * FROM `ORDER` WHERE `ORDER`.VendorId = '$VendorId' AND `ORDER`.`Status` = 'DELIVERED' ORDER BY `ORDER`.DateTimeOfOrder") or die(mysql_error());

        $resultCanceled = mysql_query("SELECT * FROM `ORDER` WHERE `ORDER`.VendorId = '$VendorId' AND `ORDER`.`Status` = 'CANCELED' ORDER BY `ORDER`.DateTimeOfOrder") or die(mysql_error());

        $_SESSION['resultPending'] = $resultPending;
        $_SESSION['resultDelivered'] = $resultDelivered;
        $_SESSION['resultCanceled'] = $resultCanceled;

    }
?>