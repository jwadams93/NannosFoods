<?php

function ui_show_store_loc_result($message){

    echo "<html>";
    echo "<head>";
    echo "</head>";
    echo "<body>";

    if($message){
        if($message != ""){
            echo '<center><font="blue">'.$message.'</font></center><br />';
        }
    }

    echo <<<UPTOEND
        <br/><br/>
        <center>
        <input type="button" value="Return to Main Menu" onClick="window.location='../view/index.html'"/>
        </center>
UPTOEND;

    echo "</body>";
    echo "</html>";
}

?>