<?php
    require('./access_db.php');

    connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

    if(isset($_GET['VendorCode'])){
        $VendorCode = $_GET['VendorCode'];
    }

    $query = "SELECT * FROM VENDOR WHERE VendorCode = '$VendorCode'";

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
    <title>Modify Vendor | Nanno's Foods</title>
</head>
<body>

    <?php require('./header/header.php'); ?>

    <div class="container container shadow p-4 mb-5 mt-5 bg-white rounded">

            <form action="../model/vendor_modify.php" method="POST">

                <?php
                    echo "<h1>Modifying Vendor: ";
                    echo $results['VendorName'];
                    echo "</h1>" ;
                ?>

                <input type="hidden" name="VendorCode" value="<?php echo $results['VendorCode']?>">


                <div class="form-group">
                    <label>Vendor Name</label>
                    <input type="text" name="VendorName" value="<?php echo $results['VendorName']?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="Address" value="<?php echo $results['Address']?>" class="form-control" required>
                </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" name="City" value="<?php echo $results['City']?>" class="form-control"
                    pattern="[A-Z][a-z]*((-|\s){1}([A-Z]?[a-z]*))*"
                    title="Invalid City: Ex. City, City-Name, City-name, City Name, City name"/>
                </div>

                <div class="form-group col-md-4">
                    <label>State</label>
                    <select id='state' name='State' class="custom-select form-control" required>
						            <option value="<?php echo $results['State']?>" selected><?php echo $results['State']?></option>
						            <option value='Alaska'>Alaska</option>
                        <option value='Alabama'>Alabama</option>
                        <option value='American Samoa'>American Samoa</option>
                        <option value='Arkansas'>Arkansas</option>
                        <option value='Arizona'>Arizona</option>
                        <option value='California'>California</option>
                        <option value='Colorado'>Colorado</option>
                        <option value='Connecticut'>Connecticut</option>
                        <option value='D.C.'>District of Columbia</option>
                        <option value='Delaware'>Delaware</option>
                        <option value='Florida'>Florida</option>
                        <option value='Georgia'>Georgia</option>
                        <option value='Guam'>Guam</option>
                        <option value='Hawaii'>Hawaii</option>
                        <option value='Iowa'>Iowa</option>
                        <option value='Idaho'>Idaho</option>
                        <option value='Illinois'>Illinois</option>
                        <option value='Indiana'>Indiana</option>
                        <option value='Kansas'>Kansas</option>
                        <option value='Kentucky'>Kentucky</option>
                        <option value='Louisiana'>Louisiana</option>
                        <option value='Massachusetts'>Massachusetts</option>
                        <option value='Maryland'>Maryland</option>
                        <option value='Maine'>Maine</option>
                        <option value='Michigan'>Michigan</option>
                        <option value='Minnesota'>Minnesota</option>
                        <option value='Missouri'>Missouri</option>
                        <option value='Mississippi'>Mississippi</option>
                        <option value='Montana'>Montana</option>
                        <option value='North Carolina'>North Carolina</option>
                        <option value='North Dakota'>North Dakota</option>
                        <option value='Nebraska'>Nebraska</option>
                        <option value='New Hampshire'>New Hampshire</option>
                        <option value='New Jersey'>New Jersey</option>
                        <option value='New Mexico'>New Mexico</option>
                        <option value='Nevada'>Nevada</option>
                        <option value='New York'>New York</option>
                        <option value='Ohio'>Ohio</option>
                        <option value='Oklahoma'>Oklahoma</option>
                        <option value='Oregon'>Oregon</option>
                        <option value='Pennsylvania'>Pennsylvania</option>
                        <option value='Puerto Rico'>Puerto Rico</option>
                        <option value='Rhode Island'>Rhode Island</option>
                        <option value='South Carolina'>South Carolina</option>
                        <option value='South Dakota'>South Dakota</option>
                        <option value='Tennessee'>Tennessee</option>
                        <option value='Texas'>Texas</option>
                        <option value='Utah'>Utah</option>
                        <option value='Virginia'>Virginia</option>
                        <option value='Virgin Islands'>Virgin Islands</option>
                        <option value='Vermont'>Vermont</option>
                        <option value='Washington'>Washington</option>
                        <option value='Wisconsin'>Wisconsin</option>
                        <option value='West Virginia'>West Virginia</option>
                        <option value='Wyoming'>Wyoming</option>
					           </select>
                </div>

                <div class="form-group col-md-2">
                    <label>ZIP</label>
                    <input type="text" name="ZIP" value="<?php echo $results['ZIP']?>" class="form-control" required
                    pattern="[0-9]{5}" title="Zipcode must be exactly 5 digits"/>
                </div>
            </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="Phone" value="<?php echo $results['Phone']?>" class="form-control"
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="Invalid Phone: Must be in format XXX-XXX-XXXX"/>
                </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ContactPersonName</label>
                    <input type="text" name="ContactPersonName" value="<?php echo $results['ContactPersonName']?>" class="form-control" required
                    pattern="^[A-Z][a-z]*|[A-Z][a-z]*((-|\s)[A-Z][a-z]*)*"
                    title="Name Invalid: Names must begin with a capital: John, John-Brown, John Peters"/>
                </div>

                <div class="form-group col-md-6">
                    <label>Password</label>
                    <input type="text" name="Password" value="<?php echo $results['Password']?>" class="form-control" required
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"/>
                </div>
            </div>

                <div class="form-group">
                    <label>ActiveStatus</label>
                    <select name="ActiveStatus" class="form-control">
                        <option selected><?php echo $results['ActiveStatus']?></option>

                        <?php
                            if($results['ActiveStatus'] == 'inactive'):
                                echo '<option value="active">active</option>';
                            else:
                                echo '<option value="inactive">inactive</option>';
                            endif;
                        ?>

                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-primary" value="Reset">
                    <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./vendorCRUD.php'">
                </div>
            </form>
    </div>

</body>
</html>