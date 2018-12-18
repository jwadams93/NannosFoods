<?php 

session_start(); 
require('../view/access_db.php');

clickedTableRow();

function clickedTableRow(){
    if(isset($_GET['OrderId'])){

        connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

        $OrderId = $_GET['OrderId'];
        $itemInfoForClicked = array();

        $itemInfoForClicked = mysql_query("SELECT i.ItemId, i.Description, od.QuantityOrdered FROM `ORDER` o, ORDERDETAIL od, INVENTORYITEM i WHERE o.OrderId = '$OrderId' AND o.OrderId = od.OrderId AND od.ItemId = i.ItemId");

        $_SESSION['itemInfoForClicked'] = $itemInfoForClicked;
    
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../view/style/style.css">
    <title>View Orders</title>
</head>
 
<body>

<!-- NAV BAR -->

<?php require_once('../view/header/vendorHeader.php'); ?>

<!-- END NAV BAR -->

<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">
        <h5>Contents of Order <?php echo $_GET['OrderId'];?></h5>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Item Id</th>
                <th>Description</th>
                <th>Quantity Ordered</th>
            </tr>
            </thead>
        <tbody>
            <?php
            if(isset($_SESSION['itemInfoForClicked'])){

                if(mysql_num_rows($_SESSION['itemInfoForClicked']) == 0){
                    echo
                    '<tr>
                        <td colspan="3">
                            This Order has no items!
                        </td>
                    </tr>';
                }

                while($row = mysql_fetch_array($_SESSION['itemInfoForClicked'])){
                    echo 
                    '<tr>
                        <td>'. $row['ItemId'] .'</td>
                        <td>'. $row['Description'].'</td>
                        <td>'. $row['QuantityOrdered'] .'</td>
                    </tr>';
                }
            }
            ?>
        </tbody>
        </table>
    
    <input type="button" value='Back' class='btn btn-info' onClick='window.location="../view/view_orders_ui.php"'>
</div>      

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>