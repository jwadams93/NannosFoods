<?php session_start()?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
    <title>Store | Nanno's Food</title>
</head>

<body>

<!-- Grab Store Info -->
<?php
    require('./access_db.php');

    connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

    //Check Customer
    if(isset($_POST['CustomerId'])){
        $CustomerId = mysql_real_escape_string($_POST['CustomerId']);

        $CustomerFind = mysql_query("SELECT * FROM CUSTOMER WHERE customerID = '$CustomerId'");

        if(mysql_num_rows($CustomerFind) == 0){
            $_SESSION['custMessage'] = "Sorry, A customer with this Id does not exist in our database.";
            $_SESSION['msg_type'] = "danger";

            header("location: ../view/customerPurchaseView.php");
        }
    }


    if(isset($_SESSION['StoreId'])){

        $storeId = $_SESSION['StoreId'];
        unset($_SESSION['StoreId']);

    }elseif(isset($_POST['StoreName'])){

        $storeId = $_POST['StoreName'];

    }

    //Store Info
    $StoreQuery = mysql_query("SELECT * FROM RETAILSTORE WHERE StoreId = '$storeId'");

    $StoreResult = mysql_fetch_array($StoreQuery);

    //Inventory of Store
    $StoreInvQuery = mysql_query("SELECT * FROM INVENTORY WHERE StoreId = '$storeId'");

    //Inventory Items

    $InvItemsQuery = mysql_query("SELECT * FROM INVENTORYITEM WHERE ItemId = '$ItemId'");
?>
<!-- End Grab Store Info -->

<!-- NAV BAR -->
<?php require_once('./header/header.php'); ?>
<!-- END NAV BAR -->

<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">

    <h1 class="text-center mb-4">Welcome to the inventory page for <?php echo $StoreResult['StoreName']; ?></h1>

<!-- MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>

    <div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible fade show mt-4 shadow-sm rounded" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        ?>
    
    </div>

    <?php endif ?>
<!-- END MESSAGE -->


    <div class="row">
        <?php
            while($StoreInvResult = mysql_fetch_array($StoreInvQuery)){
                $InvItemsQuery = mysql_query("SELECT * FROM INVENTORYITEM WHERE ItemId = " . $StoreInvResult['ItemId'] );
                while($InvItemsResult = mysql_fetch_array($InvItemsQuery)){
                    echo '<div class="col-lg-4 pb-2 d-flex justify-content-around">';
                    echo '<div class="card h-100 mb-2" style="width:300px">';
                        echo'<img class="card-img-top" src="./style/img/food.jpg" alt="Card image">';
                        echo '<div class="card-body h-100 d-flex flex-column justify-content-between">';
                            echo '<h4 class="card-title">'. $InvItemsResult['Description'] .'</h4>';
                            echo '<p class="card-text"> Price $'. $InvItemsResult['ItemRetail'] . '</p>';
                            echo '<p class="card-text"> Quantity in Stock: '. $StoreInvResult['QuantityInStock']. '</p>';
                            echo '
                            <div class="card-footer">';
                            
                                if($StoreInvResult["QuantityInStock"] > 0){
                                echo '<form class="form-inline my-2 my-lg-0 d-flex justify-content-around" action="../model/customerPurchase.php" method="POST">
                                    <input type="hidden" name="ItemId" value="'.$StoreInvResult['ItemId'].'">
                                    <input type="hidden" name="StoreId" value="'.$storeId.'">
                                    <input type="hidden" name="CustomerId" value="'.$_POST['CustomerId'].'">

                                    <input type="number" name="Quantity" placeholder="#" class="form-control" min="1" max='. $StoreInvResult['QuantityInStock'] .' required>
                                    <input type="submit" name="search" class="btn btn-outline-primary" value="Purchase">

                                </form>';
                                }else{
                                    echo '<h4>Out of Stock</h4>';
                                }

                            echo'</div>';
                        echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        ?>

    </div>
    <div class="d-flex flex-row-reverse m-2">
        <input type="button" class="btn btn-outline-primary" onclick="location.href='./customerPurchaseView.php';" value="Return to Store Select">
    </div>

</div>
</body>
</html>