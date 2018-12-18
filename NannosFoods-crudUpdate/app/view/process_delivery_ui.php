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
    <title>Process a delivery</title>
</head>
 
<body>

<!-- NAV BAR -->

<?php require_once('./header/header.php'); ?>

<!-- END NAV BAR -->

<!-- START PRIMARY INPUT FORM -->

<div class="container">

<div class="card mx-auto m-5 w-50 shadow p-3 mb-5 bg-white rounded" style="width: 18rem;">
   <div class="card-body">
       <h1 class="text-center mb-4">Process a Delivery</h1>
   <form action="../model/process_delivery.php" method='post'>
        <div class="form-group mb-4">
            <label>Enter an Order Id</label>
            <input name="OrderId" type="input" class="form-control" required pattern="^[0-9]+$" title="Order Id must be a number!">
        </div>

        <button type="submit" class="btn btn-primary">
            Submit
        </button>

        <?php if($_SESSION['msg_type'] == 'success'): ?>

            <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#primaryModal">
                View Delivery
            </button>

        <?php else: ?>

            <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#primaryModal" disabled>
                View Delivery
            </button>            

        <?php endif ?>
        <!-- <input type="submit" class="btn btn-primary" value="Submit" data-toggle="modal" data-target="#primaryModal"> -->

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

           <?php session_destroy(); ?>

        <?php endif ?>

   </form>
   </div>
</div>

<!-- END PRIMARY INPUT FROM -->

<!-- MODAL START -->

<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="primaryModalLabel">Order Processed!</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>The following items have been updated</h5>
        <?php if(isset($_SESSION['updatedItemArray'])): ?> 

        <?php  
            echo'
            <ul class="list-group">';

            foreach($_SESSION['updatedItemArray'] as $key=>$value){
            // and print out the values

            echo'<li class="list-group-item">
                The Item '."'".$key."'".' now has '."'".$value."'".' units in stock'.' 
                </li>';
            }

            echo'</ul>';
        ?>
        <?php endif ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL END -->

</div>
</body>

</html>