<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    
    $SERVER = 'us-cdbr-azure-central-a.cloudapp.net';
    $USER = 'bf7f0622e9427e';
    $PASS = '720ad0bb';
    $DATABASE = 'cs3380-pah9qd';
    
    $mylink = new mysqli($SERVER, $USER, $PASS, $DATABASE);
    $_SESSION['mylink'] = $mylink;
?>