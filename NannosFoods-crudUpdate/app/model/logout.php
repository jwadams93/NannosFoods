<?php

    require('../view/access_db.php');

    logout();

    function logout(){

    Session_start();
    Session_destroy();

    header("location: ../view/index.html");
}

?>