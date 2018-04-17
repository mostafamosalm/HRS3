<?php
    //function used to echo page title $pagetitle

    function gettitle() {
        global $pagetitle;
        if (isset($pagetitle)) {
        echo $pagetitle;
    } else {
        echo 'Default'; // if no $pagetitle on page
    }
}

?>