<?php
    // start session
    session_start();
    session_unset();//unset data
    session_destroy(); //destroy session
    header('Location: index.php'); //redirect to login page
    exit();
    ?>