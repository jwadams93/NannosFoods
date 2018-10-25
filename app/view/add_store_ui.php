<!-- add_store_ui.php -->
<?php

//------------------------------------------------------------
// Main Control Logic: It just calls a function
ui_show_new_store_form();	

//------------------------------------------------------------
function ui_show_new_store_form()
{
  //Create an HTML document using the ECHO statements
  echo "<HTML>";
  echo "<HEAD>";
	echo "<link href='./style/style.css' rel='stylesheet' type='text/css'/>";
  echo "</HEAD>";
  echo "<BODY>";
    echo "<BR/>";
    echo "<FORM action='../model/add_store_loc.php' method='post'>";
    echo "<table>";

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Store Code:</SPAN></TD>';
      echo '<TD><INPUT NAME="StoreCode" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Store Name:</SPAN></TD>';
      echo '<TD><INPUT NAME="StoreName" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
    
      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Address:</SPAN></TD>';
      echo '<TD><INPUT NAME="Address" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>City:</SPAN></TD>';
      echo '<TD><INPUT NAME="City" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
	  
	    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>State:</SPAN></TD>';
      echo '<TD><INPUT NAME="State" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
	  
	    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Zip:</SPAN></TD>';
      echo '<TD><INPUT NAME="ZIP" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
      
      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Phone:</SPAN></TD>';
      echo '<TD><INPUT NAME="Phone" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
	  
	    echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Manager Name:</SPAN></TD>';
      echo '<TD><INPUT NAME="ManagerName" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

  echo "</table>";
  echo '<input type="submit" class="button" value="Submit New Store Data" />';
  echo '<input type="reset" class="button" value="Reset" />';
 
  echo "</FORM>";
  echo "</BODY>";
  echo "</HTML>";
}
?>
