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

<!-- PENDING -->

<h1>Pending Orders:</h1>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Order Id</th>
        <th>Store Id</th>
        <th>Date/Time of Order</th>
        <th>Date/Time of Fulfilment</th>
        <th>Order Info</th>
      </tr>
    </thead>
    <tbody>

    <?php
    if(mysql_num_rows($_SESSION['resultPending']) == 0){
        echo
        '<tr>
            <td colspan="4">
                You have no pending orders
            </td>
        </tr>';
    }

        while($row = mysql_fetch_array($_SESSION['resultPending'])){
            echo 
            '<tr>'.'
                <td>'. $row['OrderId'] .'</td>
                <td>'. $row['StoreId'].'</td>
                <td>'. $row['DateTimeOfOrder'] .'</td>
                <td>'. $row['DateTimeOfFulfilment'] ."</td>".
                "<td>".
                "<input type='button' name='orderInfo' value='More...' class='btn btn-info' onClick=".'"window.location='."'../model/clickedTableRow.php?OrderId=".$row['OrderId']."'".'"/>'
                ."</td>".
            "</tr>";
        }
    ?>
    </tbody>
</table>

<!-- DELIVERED -->
<h1>Delivered Orders:</h1>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Order Id</th>
        <th>Store Id</th>
        <th>Date/Time of Order</th>
        <th>Date/Time of Fulfilment</th>
      </tr>
    </thead>
    <tbody>

    <?php
    if(mysql_num_rows($_SESSION['resultDelivered']) == 0){
        echo
        '<tr>
            <td colspan="4">
                Your Orders have yet to be delivered
            </td>
        </tr>';
    }

        while($row = mysql_fetch_array($_SESSION['resultDelivered'])){
            echo 
            '<tr>'.'
                <td>'. $row['OrderId'] .'</td>
                <td>'. $row['StoreId'].'</td>
                <td>'. $row['DateTimeOfOrder'] .'</td>
                <td>'. $row['DateTimeOfFulfilment'] ."</td>".
                "<td>".
                "<input type='button' name='orderInfo' value='More...' class='btn btn-info' onClick=".'"window.location='."'../model/clickedTableRow.php?OrderId=".$row['OrderId']."'".'"/>'
                ."</td>".
            "</tr>";
        }
    ?>
    </tbody>
</table>

<!-- CANCELED -->
<h1>Canceled Orders:</h1>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Order Id</th>
        <th>Store Id</th>
        <th>Date/Time of Order</th>
        <th>Date/Time of Fulfilment</th>
      </tr>
    </thead>
    <tbody>

    <?php
        if(mysql_num_rows($_SESSION['resultCanceled']) == 0){
            echo
            '<tr>
                <td colspan="4">
                    You have no canceled orders
                </td>
            </tr>';
        }

        while($row = mysql_fetch_array($_SESSION['resultCanceled'])){
            echo 
            '<tr>'.'
                <td>'. $row['OrderId'] .'</td>
                <td>'. $row['StoreId'].'</td>
                <td>'. $row['DateTimeOfOrder'] .'</td>
                <td>'. $row['DateTimeOfFulfilment'] ."</td>".
                "<td>".
                "<input type='button' name='orderInfo' value='More...' class='btn btn-info' onClick=".'"window.location='."'../model/clickedTableRow.php?OrderId=".$row['OrderId']."'".'"/>'
                ."</td>".
            "</tr>";
        }
    ?>
    </tbody>
</table>
