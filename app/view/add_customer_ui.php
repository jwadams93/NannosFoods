<!-- add_store_ui.php -->
<?php

//------------------------------------------------------------
// Main Control Logic: It just calls a function
require('../model/scripts.js');
ui_show_new_customer_form();

//------------------------------------------------------------
function ui_show_new_customer_form()
{
  //Create an HTML document using the ECHO statements
  echo "<HTML>";
  echo "<HEAD>";
	 echo "<link href='./style/style.css' rel='stylesheet' type='text/css'/>";
  echo "</HEAD>";
  echo "<BODY>";
    echo "<BR/>";
    echo "<FORM action='../model/add_customer.php' method='post'>";

    //Center the form
    echo "<center>";

    echo "<h1>ADD A NEW CUSTOMER</h1>";
    echo "<table>";

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">Name:</SPAN></TD>';
      echo '<TD><INPUT NAME="name" TYPE="text" SIZE=50/></TD>';
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">Address:</SPAN></TD>';
      echo '<TD><INPUT NAME="address" TYPE="text" SIZE=50/></TD>';
    echo '</tr>';

    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">City:</SPAN></TD>';
      echo '<TD><INPUT NAME="city" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">State:</SPAN></TD>';
      echo '<TD><INPUT NAME="state" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">Zip:</SPAN></TD>';
      echo '<TD><INPUT NAME="zipcode" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">Phone:</SPAN></TD>';
      echo '<TD><INPUT NAME="phone" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT class="td_label">Email:</SPAN></TD>';
      echo '<TD><INPUT NAME="email" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
  echo "</table>";
  echo '<input type="submit" class="button" value="Submit New Customer" />';
  echo '<input type="reset" class="button" value="Reset" />';

  //ADD BACK BUTTON TO RETURN TO CUSTOMER_MAIN
  //echo '<input type="button" class="button" value="Back" onclick="window.location(\'../view/customer_main.html\')"/>';

  echo  "</FORM>";
  echo  "</BODY>";
  echo "</HTML>";
}
