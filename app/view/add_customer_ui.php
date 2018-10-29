<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <title>Add a New Customer | Nanno's Food</title>
</head>
<body>


<div class="container">
  <div class="heading">
    <h1>Add a New Customer</h1>
  </div>


  <form action="../model/add_customer.php" method='post'>

                  <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="Name" value="<?php echo $results['Name']?>" class="form-control">
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
                      <select name='state' class="custom-select form-control">
                        <option value='alaska'>Alaska</option>
                        <option value='alabama'>Alabama</option>
                        <option value='american samoa'>American Samoa</option>
                        <option value='arkansas'>Arkansas</option>
                        <option value='arizona'>Arizona</option>
                        <option value='california'>California</option>
                        <option value='colorado'>Colorado</option>
                        <option value='connecticut'>Connecticut</option>
                        <option value='D.C.'>District of Columbia</option>
                        <option value='delaware'>Delaware</option>
                        <option value='florida'>Florida</option>
                        <option value='georgia'>Georgia</option>
                        <option value='guam'>Guam</option>
                        <option value='hawaii'>Hawaii</option>
                        <option value='iowa'>Iowa</option>
                        <option value='idaho'>Idaho</option>
                        <option value='illinois'>Illinois</option>
                        <option value='indiana'>Indiana</option>
                        <option value='kansas'>Kansas</option>
                        <option value='kentucky'>Kentucky</option>
                        <option value='louisiana'>Louisiana</option>
                        <option value='massachusetts'>Massachusetts</option>
                        <option value='maryland'>Maryland</option>
                        <option value='maine'>Maine</option>
                        <option value='michigan'>Michigan</option>
                        <option value='minnesota'>Minnesota</option>
                        <option value='missouri'>Missouri</option>
                        <option value='mississippi'>Mississippi</option>
                        <option value='montana'>Montana</option>
                        <option value='north carolina'>North Carolina</option>
                        <option value='north dakota'>North Dakota</option>
                        <option value='nebraska'>Nebraska</option>
                        <option value='new hampshire'>New Hampshire</option>
                        <option value='new jersey'>New Jersey</option>
                        <option value='new mexico'>New Mexico</option>
                        <option value='nevada'>Nevada</option>
                        <option value='new york' selected='selected'>New York</option>
                        <option value='ohio'>Ohio</option>
                        <option value='oklahoma'>Oklahoma</option>
                        <option value='oregon'>Oregon</option>
                        <option value='pennsylvania'>Pennsylvania</option>
                        <option value='puerto rico'>Puerto Rico</option>
                        <option value='rhode island'>Rhode Island</option>
                        <option value='south carolina'>South Carolina</option>
                        <option value='south dakota'>South Dakota</option>
                        <option value='tennessee'>Tennessee</option>
                        <option value='texas'>Texas</option>
                        <option value='utah'>Utah</option>
                        <option value='virginia'>Virginia</option>
                        <option value='virgin islands'>Virgin Islands</option>
                        <option value='vermont'>Vermont</option>
                        <option value='washington'>Washington</option>
                        <option value='wisconsin'>Wisconsin</option>
                        <option value='west virginia'>West Virginia</option>
                        <option value='wyoming'>Wyoming</option>
                    </select>
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
                      <label>Email</label>
                      <input type="text" name="Email" value="<?php echo $results['Email']?>" class="form-control">
                  </div>

                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Submit">
                      <input type="reset" class="btn btn-primary" value="Reset">
                      <input type="button" name="back" class="btn btn-primary" value="Back" onClick="window.location='./customer_main.html'">
                  </div>
  </form>
</div>
</body>
</html>