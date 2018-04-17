<?php
    include '../layouts/connect.php';

    //routes
    $tpl = '../includes/templates/';
    $css = '../layouts/css/';
    $js = '../layouts/js/';
    $en = '../includes/languages/';
    $func = '../includes/functions/';

    // INCLUDE OTHER FILES
    include $func . 'function.php';
    include $tpl . 'header.php';
    
    // include nav-bar on all pages expect that has $nonavbar
    if (!isset($nonavbar)) {
        include $tpl . 'nav-bar.php';
        include $tpl . 'side-bar.php';
    }
?>
