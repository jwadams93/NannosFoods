<!-- new_item_ui.php -->
<?php
session_start();

//------------------------------------------------------------
// Main Control Logic: It just calls a function
ui_show_new_item_form();

//------------------------------------------------------------
function ui_show_new_item_form()
{
  $row = $_SESSION['result'];
  if($row != null){
    $cId = $row['customerId'];
    $name = $row['customerName'];
    $address = $row['Address'];
    $city = $row['City'];
    $state = $row['State'];
    $zip = $row['ZIP'];
    $phone = $row['Phone'];
    $email = $row['customerEmail'];
  }
  else{
    $cId = $name = $address = $city = $state = $zip = $phone = $email = "";
  }
  //Create an HTML document using the ECHO statements
  echo "<HTML>";
  echo "<HEAD>";
	echo "<link href='./style/style.css' rel='stylesheet' type='text/css'/>";
  echo "</HEAD>";
  echo "<BODY>";
    echo "<BR/>";
    echo "<FORM action='./modify_customer.php' method='post'>";
    echo "<table>";

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Customer Id:</SPAN></TD>';
      echo "<TD>$cId</TD>";
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Name:</SPAN></TD>';
      echo "<TD><INPUT NAME='name' TYPE='text' placeholder='$name' SIZE=50/></TD>";
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Address:</SPAN></TD>';
      echo "<TD><INPUT NAME='address' placeholder='$address' TYPE='text' SIZE=50/></TD>";
    echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>City:</SPAN></TD>';
      echo "<TD><INPUT NAME='city' placeholder='$city' TYPE='text' SIZE=50/></TD>";
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>State:</SPAN></TD>';
      echo "<TD><INPUT NAME='state' placeholder='$state' TYPE='text' SIZE=50/></TD>";
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>ZipCode:</SPAN></TD>';
      echo "<TD><INPUT NAME='zipcode' placeholder='$zip' TYPE='text' SIZE=50/></TD>";
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Phone:</SPAN></TD>';
      echo "<TD><INPUT NAME='phone' placeholder='$phone' TYPE='text' SIZE=50/></TD>";
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Email:</SPAN></TD>';
      echo "<TD><INPUT NAME='email' placeholder='$email' TYPE='text' SIZE=50/></TD>";
    echo '</tr>';
  echo "</table>";
  echo '<input type="submit" class="button" value="Submit New Item Data" />';
  echo '<input type="reset" class="button" value="Reset" />';
  //CODE HERE: Add some sort of back button?
}
?>
