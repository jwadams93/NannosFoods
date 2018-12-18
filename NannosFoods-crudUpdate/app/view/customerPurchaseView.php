<?php session_start();?>
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
    <title>Purchase | Nanno's Food</title>
</head>

<body>

<!-- Grab Store Info -->
<?php
    require('./access_db.php');

    connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

    $query= mysql_query("SELECT * FROM RETAILSTORE");
?>
<!-- End Grab Store Info -->

<!-- NAV BAR -->
<?php require_once('./header/header.php'); ?>
<!-- END NAV BAR -->


<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">

        <h1 class="text-center mb-4">Customer Purchase</h1>

        <form action="storeItemSelection.php" method='post'>

            <div class="form-row">
                <div class="form-group col-mb-6">
                    <label>Enter Customer Id</label>
                    <input name="CustomerId" type="input" class="form-control" required pattern="^[0-9]+$" title="Customer Id must be a number!" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Store Name</label>
                    <select name="StoreName" class="custom-select form-control" required>
                        <option selected><?php echo $results['StoreName']?></option>

                        <?php
                            while($store_result = mysql_fetch_array($query)){
                                echo "<option value='".$store_result['StoreId']."'>";
                                echo $store_result['StoreId'] .' | '. $store_result['StoreName'];
                                echo '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            ?>

            <button type="submit" class="btn btn-primary">
                Browse Selection
            </button>
        </form>


<!-- MESSAGE -->
<?php if(isset($_SESSION['custMessage'])): ?>

        <div class="alert mt-3 alert-<?=$_SESSION['msg_type']?>">

            <?php 
                echo $_SESSION['custMessage'];
                unset($_SESSION['custMessage']);
            ?>

        </div>

<?php endif ?>
<!-- END MESSAGE -->

</div>
</body>

</html>