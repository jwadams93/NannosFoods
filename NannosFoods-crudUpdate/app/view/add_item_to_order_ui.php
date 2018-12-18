<?php session_start()?>

<!doctype html>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    
    <title>Add an Item to an Existing Order | Nanno's Foods</title>
</head>
 
<body>

<!-- NAV BAR -->

<?php require('./header/header.php'); ?>

<!-- END NAV BAR -->

<?php
$_SESSION['displayForm'] = true;
$_SESSION['displayItems'] = false;

//will hide search order card if input is valid
?>
<?php if($_SESSION['displayForm'] == true) :?>
<div class="container">

<div class="card mx-auto m-5 w-50 shadow p-3 mb-5 bg-white rounded" style="width: 18rem;">
   <div class="card-body">
       <h1 class="text-center mb-4">Add Items to an Order</h1>
   <form action="../model/add_item_to_order.php" method='post'>
        <div class="form-group mb-4">
            <label>Enter the Order Id:</label>
            <input name="OrderId" type="input" class="form-control" required pattern="^[0-9]+$" title="Order Id must be a number!">
        </div>

        <input type="submit" class="btn btn-primary" value="Submit">

        <?php if(isset($_SESSION['message'])): ?>

        <?php print_r($_SESSION); ?>

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
   </form>
   </div>
</div>
</div>
<?php endif ?>

<?php if(isset($_SESSION['updatedItemArray'])):?>

<div class="container">

<div class="card mx-auto m-5 w-50 shadow p-3 mb-5 bg-white rounded" style="width: 18rem;">
   <div class="card-body">
       <h1 class="text-center mb-4">Your Current Order</h1>
   <form action="../model/process_add_item_to_order.php" method='post'>
        <div class="form-group mb-4">
        <?php if(isset($_SESSION['updatedItemArray'])): ?> 
		<?php  
            echo'
            <ul class="list-group">';
			//Print current order 
            foreach($_SESSION['orderItemArray'] as $key=>$value){

            echo'<li class="list-group-item">
                Item Id: '.$key.' Quantity: '.$value.'</li>';
            }
            echo'</ul>';
        ?>
		<?php endif ?>
        </div>
		
		<div class="form-group mb-4">
            <label>Choose the Items you Wish to Add</label>
          <select name="itemNames" id="ItemNames" class="custom-select form-control" required>
          <?php
			  //display optional items based on vendorId
              echo'<ul class="list-group">';
			  foreach($_SESSION['vendorItems'] as $key=>$value ){
                echo'<li class="list-group-item">
				Item Id: '.$key."    description: ".$value;
				echo '<input type="checkbox" name="items[]" value="'.$_SESSION['vendorItems'].'"/>';
				echo 'Quantity: ';
				echo '<input type="text" name="quantities" value="quantities">';
				echo '</li>';
			}
			echo '</ul>';
          ?>
        </select>
        </div>
        <input type="submit" class="btn btn-primary" name="addItemsBtn" value="Submit">
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
   </form>
   </div>
</div>
</div>
<?php endif ?>

<?php session_destroy(); ?>
</body>

</html>