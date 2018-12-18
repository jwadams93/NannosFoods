<?php session_start(); ?>
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
    <title>View Orders</title>
</head>
 
<body>

<!-- NAV BAR -->

<?php require_once('./header/vendorHeader.php'); ?>

<!-- END NAV BAR -->

<!-- START PAGE CONTENT -->

<!-- Create an if statement that checks if a session variable is "logged in".-->
<!-- if is logged in, open template that shows orders-->
<!-- is is not logged in, redirect to log in page-->
<?php 
    if($_SESSION['loggedIn'] == false || null){
        header("location: ../view/login_ui.php");
    }
?>

<div class="container shadow p-4 mb-5 mt-5 bg-white rounded">
    <?php require('./order_table.php'); ?>
</div>
<!-- END PAGE CONTENT -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                $('#primaryModal').modal('show')
            });
        });
    </script>
</body>

</html>