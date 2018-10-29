<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <title>Add a New Store | Nanno's Food</title>
</head>
<body>
  
<div class="container">
  <div class="heading">
    <h1>Add a new store</h1>
  </div>


  <form action="../model/add_store_loc.php" method='post'>
                  <div class="form-group">
                      <label>Store Code</label>
                      <input type="text" name="StoreCode" value="<?php echo $results['StoreCode']?>" class="form-control">
                  </div>
  
                  <div class="form-group">
                      <label>Store Name</label>
                      <input type="text" name="StoreName" value="<?php echo $results['StoreName']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="Address" value="<?php echo $results['Address']?>" class="form-control">
                  </div>
              
                  <div class="form-group">
                      <label>City</label>
                      <input type="text" name="City" value="<?php echo $results['City']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>State</label>
                      <input type="text" name="State" value="<?php echo $results['State']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>ZIP</label>
                      <input type="text" name="ZIP" value="<?php echo $results['ZIP']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>Phone</label>
                      <input type="text" name="Phone" value="<?php echo $results['Phone']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>Manager Name</label>
                      <input type="text" name="ManagerName" value="<?php echo $results['ManagerName']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Submit">
                      <input type="reset" class="btn btn-primary" value="Reset">
                      <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./store_main.html'">
                  </div>
  </form>
</div>
</body>
</html>