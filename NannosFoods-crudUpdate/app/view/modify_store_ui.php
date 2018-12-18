<?php
    require('./access_db.php');

    connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

    if(isset($_GET['i'])){
        $id = $_GET['i'];
    }

if(isset($_GET['StoreCode'])){
    $StoreCode = $_GET['StoreCode'];
}

$query = "SELECT * FROM RETAILSTORE WHERE StoreCode = '$StoreCode'";

$results = mysql_fetch_array(mysql_query($query));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">

    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
    <title>Modify Store</title>
</head>
<body>
    <?php require('./header/header.php'); ?>

    <div class="container container shadow p-4 mb-5 mt-5 bg-white rounded">
 
            <form action="../model/store_modify.php" method="POST">

                <?php
                    echo "<h1>Modifying Store ";
                    echo $results['StoreName'];
                    echo " (Store Code: ";
                    echo $results['StoreCode'];
                    echo ") </h1>" ;
                ?>

                <input type="hidden" name="StoreCode" value="<?php echo $results['StoreCode']?>">

                <div class="form-group">
                    <label>Store Name</label>
                    <input type="text" name="StoreName" value="<?php echo $results['StoreName']?>" class="form-control" required pattern="[A-Z][a-z]*[']?[a-z]*((-|\s)[A-Z][a-z]*)*" title="Example: Store, Store-Name, Store Name, Store-Name-Long"/>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="Address" value="<?php echo $results['Address']?>" class="form-control" >
                </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" name="City" value="<?php echo $results['City']?>" class="form-control" required pattern="[A-Z][a-z]*((-|\s){1}([A-Z]?[a-z]*))*"
                      title="Invalid City: Ex. City, City-Name, City-name, City Name, City name">
                </div>

                <div class="form-group col-md-4">
                    <label>State</label>
                    <input type="text" name="State" value="<?php echo $results['State']?>" class="form-control">
                </div>

                <div class="form-group col-md-2">
                    <label>ZIP</label>
                    <input type="text" name="ZIP" value="<?php echo $results['ZIP']?>" class="form-control" required pattern="[0-9]{5}" title="Zipcode must contain exactly 5 digits">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="text" name="Phone" value="<?php echo $results['Phone']?>" class="form-control" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="Phone must be in the format: XXX-XXX-XXXX" data-inputmask="'mask': '(999) 999-9999'">
                </div>

                <div class="form-group col-md-6">
                    <label>Manager Name</label>
                    <input type="text" name="ManagerName" value="<?php echo $results['ManagerName']?>" class="form-control" required
                      pattern="^[A-Z][a-z]*|[A-Z][a-z]*((-|\s)[A-Z][a-z]*)*"
                      title="Name Invalid: Names must begin with a capital: John, John-Brown, John Peters">
                </div>
            </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-primary" value="Reset">
                    <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./storeCRUD.php'">
                </div>
            </form>

    </div>

</body>
</html>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>