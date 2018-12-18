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
  <title>Add a New Store | Nanno's Food</title>
</head>
<body>

<?php require('./header/header.php'); ?>

<div class="container container shadow p-4 mb-5 mt-5 bg-white rounded">
  <div class="heading">
    <h1>Add a new store</h1>
  </div>


  <form action="../model/add_store_loc.php" method='post'>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Store Code</label>
                    <input type="text" name="StoreCode" class="form-control" required
                      pattern="[0-9]+" title="Only numerical digits allowed"/>
                </div>

                <div class="form-group col-md-6">
                    <label>Store Name</label>
                    <input type="text" name="StoreName" value="" class="form-control" required pattern="[A-Z][a-z]*[']?[a-z]*((-|\s)[A-Z][a-z]*)*" title="Example: Store, Store-Name, Store Name, Store-Name-Long"/>
                </div>
            </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="Address" value="" class="form-control" required>
                </div>

            <div class="form-row no-gutters">
                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" name="City" value="" class="form-control" required pattern="[A-Z][a-z]*((-|\s){1}([A-Z]?[a-z]*))*"
                      title="Invalid City: Ex. City, City-Name, City-name, City Name, City name"/>
                </div>

                <div class="form-group col-md-4">
                    <label>State</label>
                    <select id='state' name='State' class="custom-select form-control" required>
                        <option>Choose...</option>
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
                    <input type="text" name="ZIP" value="" class="form-control" required pattern="[0-9]{5}" title="Zipcode must contain exactly 5 digits"/>
                </div>
            </div>

            <div class="form-row no-gutters">
                <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="text" name="Phone" value="" class="form-control" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" title="Phone must be in the format: XXX-XXX-XXXX" data-inputmask="'mask': '(999) 999-9999'"/>
                </div>

                <div class="form-group col-md-6">
                    <label>Manager Name</label>
                    <input type="text" name="ManagerName" value="" class="form-control" required
                      pattern="^[A-Z][a-z]*|[A-Z][a-z]*((-|\s)[A-Z][a-z]*)*"
                      title="Name Invalid: Names must begin with a capital: John, John-Brown, John Peters"/>
                </div>
            </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-primary" value="Reset">
                    <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./managerHome.php'">
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