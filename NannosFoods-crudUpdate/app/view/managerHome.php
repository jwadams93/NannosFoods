<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaijaan" rel="stylesheet">
	<link rel="stylesheet" href="./style/style.css">
	<title>Nanno's Food</title>
</head>
<body>

	<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">

		<div class="jumbotron">
			<h1 class="display-3">Nanno's Foods</h1>
			<p class="lead">Inventory System</p>
		</div>

		<hr/>

	<ul class="nav nav-pills">
  		<li class="nav-item dropdown">
		  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Items
        	</a>
        	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          		<a class="dropdown-item" href="./add_item_ui.php">Add</a>
          		<a class="dropdown-item" href="./itemCRUD.php">Modify/Delete</a>
        	</div>
		  </li>
		  
		  <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Customer
        	</a>
        	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          		<a class="dropdown-item" href="./add_customer_ui.php">Add</a>
          		<a class="dropdown-item" href="./customerCRUD.php">Modify/Delete</a>
        	</div>
		  </li>
		  
		  <li class="nav-item dropdown">
		  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Vendor
        	</a>
        	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          		<a class="dropdown-item" href="./add_vendor_ui.php">Add</a>
          		<a class="dropdown-item" href="./vendorCRUD.php">Modify/Delete</a>
        	</div>
		  </li>
		  
		  <li class="nav-item dropdown">
		  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Locations
        	</a>
        	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          		<a class="dropdown-item" href="./add_store_ui.php">Add</a>
          		<a class="dropdown-item" href="./storeCRUD.php">Modify/Delete</a>
        	</div>
		  </li>
		  
		  <li class="nav-item dropdown">
		  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Order Processing
        	</a>
        	<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="./process_order_ui.php">Create an Order</a>
				<a class="dropdown-item" href="./add_item_order_ui.php">Add Items to an Order</a>
            	<a class="dropdown-item" href="./process_return_ui.php">Process a Return</a>
            	<a class="dropdown-item" href="./process_delivery_ui.php">Process a Delivery</a>
        	</div>
		  </li>
		  
		<li class="nav-item">
        	<a class="nav-link" href="./reports_overstocked.php">Create a Report</a>
    	</li>


			<li class="nav-item">
        		<a class="nav-link" href="./customerPurchaseView.php">Make A Purchase</a>
    		</li>

		  <hr width="1" size="5">

		  <li class="nav-item">
    		<a class="nav-link" href="index.html">Back to Login</a>
  		  </li>
	</ul>
		</div>

</body>
</html>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>