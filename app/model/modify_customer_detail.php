<!-- new_item_ui.php -->
<?php
start_session();
//------------------------------------------------------------
// Main Control Logic: It just calls a function
ui_show_new_item_form();

//------------------------------------------------------------
function ui_show_new_item_form()
{
  //Create an HTML document using the ECHO statements
  echo "<HTML>";
  echo "<HEAD>";
	echo "<link href='./style/style.css' rel='stylesheet' type='text/css'/>";
  echo "</HEAD>";
  echo "<BODY>";
    echo "<BR/>";
    echo "<FORM action='add_item.php' method='post'>";
    echo '<p>';
    echo "$_SESSION['result']";
    echo '</p>';
    echo "<table>";

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Name:</SPAN></TD>';
      echo '<TD><INPUT NAME="name" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Description:</SPAN></TD>';
      echo '<TD><INPUT NAME="description" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Promo Description:</SPAN></TD>';
      echo '<TD><INPUT NAME="promoDescription" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Size:</SPAN></TD>';
      echo '<TD><INPUT NAME="size" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Division:</SPAN></TD>';
      echo '<TD>
				<Select name="division">
					<option name="generalMerchandise">General Merchandise</option>
					<option name="seasonalMerchandise">Seasonal Merchandise</option>
				</select>
			</TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Category:</SPAN></TD>';
      echo '<TD>
				<Select name="category">
					<option name="foodAndBev">Food and Beverage</option>
					<option name="beauty">Beauty</option>
					<option name="household">Household</option>
				</select>
			</TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Item Cost:</SPAN></TD>';
      echo '<TD><INPUT NAME="itemCost" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Item Retail:</SPAN></TD>';
      echo '<TD><INPUT NAME="itemRetail" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

      echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Image Filename:</SPAN></TD>';
      echo '<TD><INPUT NAME="imageFileName" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';

	  echo '<tr>';  //
      echo '<TD><SPAN ALIGN=RIGHT>Vendor Id:</SPAN></TD>';
      echo '<TD><INPUT NAME="vendorId" TYPE="text" SIZE=50/></TD>';
      echo '</tr>';
  echo "</table>";
  echo '<input type="submit" class="button" value="Submit New Item Data" />';
  echo '<input type="reset" class="button" value="Reset" />';

}
?>
