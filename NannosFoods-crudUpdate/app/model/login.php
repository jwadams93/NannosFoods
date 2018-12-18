<?php

    require('../view/access_db.php');
    session_start();

    login();

    function login(){

        $conn = connect_and_select_db(DB_SERVER, DB_UN, DB_PWD,DB_NAME);

        $VendorCode = mysql_real_escape_string($_POST['VendorCode']);
        $Password = mysql_real_escape_string($_POST['Password']);


        $result = mysql_query("SELECT * FROM VENDOR WHERE VendorCode = '$VendorCode'", $conn);

        // SUCCESS/FAIL ALERT

        if(mysql_num_rows($result) == 0){
            
            $_SESSION['message'] = "Vendor with this Code does not exist.";
            $_SESSION['msg_type'] = "danger";

            header("location: ../view/login_ui.php");
        }else{
            
            $user = mysql_fetch_assoc($result);

            if($Password == $user['Password']){

                $_SESSION['VendorId'] = $user['VendorId'];
                $_SESSION['VendorName'] = $user['VendorName'];
                $_SESSION['loggedIn'] = true;
                
                header("location: ../view/view_orders_ui.php");
            }else{

                $_SESSION['message'] = "Incorrect password. Please try again";
                $_SESSION['msg_type'] = "danger";
                
                header("location: ../view/login_ui.php");
            }
        }
    }
?>