<?php

    require('../view/access_db.php');
    session_start();

    process_add_item_to_order();

    function process_add_item_to_order(){

        connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);
		
		$selectedItems = imlode($_POST['items']);
		
		if($result == false){
            $_SESSION['message'] = "Error Adding Items to Order! Error number: ". mysql_errno();
            $_SESSION['msg_type'] = "danger";
        }else{
            $_SESSION['message'] = "Your item(s) have been added succesfully!";
            $_SESSION['msg_type'] = "success";
    }
}
?>