<!-- new_item_ui.php -->
<?php

//------------------------------------------------------------
// Main Control Logic: It just calls a function
ui_show_modify_item_form();	

//------------------------------------------------------------
function ui_show_modify_item_form()
{
  //Create an HTML document using the ECHO statements
  echo "<HTML>";
  echo "<HEAD>";
	echo "<link href='./style/style.css' rel='stylesheet' type='text/css'/>";
  echo "</HEAD>";
  echo "<BODY>";
    echo "<BR/>";
    echo "<FORM action='search_item.php' method='post'>";
    echo "<table>";

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Item Id:</SPAN></TD>';
      echo '<TD><INPUT NAME="itemId" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
	  
  echo "</table>";
  echo '<input type="submit" class="button" value="Submit New Item Data" />';
  echo '<input type="reset" class="button" value="Reset" />';
 
  echo "</FORM>";
  echo "</BODY>";
  echo "</HTML>";
}