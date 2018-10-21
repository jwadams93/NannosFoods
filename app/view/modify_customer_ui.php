<?php
session_start();
//------------------------------------------------------------
// Main Control Logic: It just calls a function
ui_show_modify_customer_form();

//------------------------------------------------------------
function ui_show_modify_customer_form()
{
  //Create an HTML document using the ECHO statements
  echo "<HTML>";
  echo "<HEAD>";
	echo "<link href='./style/style.css' rel='stylesheet' type='text/css'/>";
  echo "</HEAD>";
  echo "<BODY>";
    echo "<BR/>";
    echo "<FORM action='../model/search_customer.php' method='post'>";
    echo "<center>";
    echo "<h2>Customer Search</h2>";
    echo "<table>";
      echo '<tr>';  //
        echo '<TD><SPAN ALIGN=RIGHT class="td_label">Customer Id:</SPAN></TD>';
        echo '<TD><INPUT NAME="customerId" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
      echo '<tr>';  //
        echo '<TD><SPAN ALIGN=RIGHT class="td_label">Name:</SPAN></TD>';
        echo '<TD><INPUT NAME="name" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
        echo '<TD><SPAN ALIGN=RIGHT class="td_label">Email:</SPAN></TD>';
        echo '<TD><INPUT NAME="email" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

    echo "</table>";
  echo '<input type="submit" class="button" value="Submit New Customer Data" />';
  echo '<input type="reset" class="button" value="Reset" />';

  echo "</center>";
  echo  "</FORM>";
  echo  "</BODY>";
  echo "</HTML>";
}
?>
