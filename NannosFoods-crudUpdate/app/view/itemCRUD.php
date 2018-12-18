<?php
   session_start();

   require('./access_db.php');

   connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

    if(isset($_POST['search'])){

        $query = $_POST['query'];

        $query = htmlspecialchars($query); 
        
        $query = mysql_real_escape_string($query);
        // makes sure nobody uses SQL injection
         
        $raw_results = mysql_query("SELECT * FROM INVENTORYITEM
            WHERE (`ItemId` LIKE '%$query%')") or die(mysql_error()); 
    }
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
    <title>Item Search | Nanno's Foods</title>
</head>

<body>

    <?php require('./header/header.php'); ?>

    <?php if(isset($_SESSION['message'])): ?>

        <div class="alert alert-<?=$_SESSION['msg_type']?>">

            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>

        </div>

    <?php endif ?>

    <div class="container container shadow p-4 mb-5 mt-5 bg-white rounded">
        <h3 class="mb-4">What is the Id of the Item you would like to search for?</h3>

        
        <form class="form-inline my-2 my-lg-0" action="itemCRUD.php" method="POST">
            <input type="text" name="query" placeholder="Search" class="form-control mr-sm-2">
            <input type="submit" name="search" class="btn btn-outline-primary my-2 my-sm-0" value="Search">
        </form>
        
    <hr/>

        <table class="table table-striped">
        <?php
            if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                echo "<thead>
                        <tr>
                          <th>Item Id</th>
                          <th>Description</th>
                          <th>Division</th>
                          <th>Department</th>
                          <th>Item Cost</th>
                          <th>Item Retail</th>
                          <th colspan='2'>Action</th>
                      </thead>
                      <tbody>";

                while($results = mysql_fetch_array($raw_results)){
                    echo "<tr>"."<td>".$results['ItemId']."</td>"
                              ."<td>".$results['Description']."</td>"
                              ."<td>".$results['Division']."</td>"
                              ."<td>".$results['Department']."</td>"
                              ."<td>".$results['ItemCost']."</td>"
                              ."<td>".$results['ItemRetail']."</td>"
                              ."<td>".
                              "<input type='button' name='modify' value='Modify' class='btn btn-info' onClick=".'"window.location='."'./modify_item_ui.php?ItemId=".$results['ItemId']."'".'"/>'
                              ."</td>"
                              ."<td>".
                                "<input type='button' name='delete' value='Delete' class='btn btn-danger' onClick=".'"window.location='."'../model/item_delete.php?ItemId=".$results['ItemId']."'".'"/>'
                              ."</td>"."</tr>";
                }
                echo "</tbody>";
            }
            else if(isset($raw_results) AND mysql_num_rows($raw_results) == 0){ // if there is no matching rows do following
                echo '<center>
              <br/><br/>
              <h5>Item not found! Would you like to add a new Item?</h5>
              <button value="newItem" name="newItem" class="btn btn-warning"
                onclick="window.location='.'\'./add_item_ui.php\''.'">Add New Item</button>
              </center>';
            }
        ?>
        </table>
    </div>
</body>
</html>