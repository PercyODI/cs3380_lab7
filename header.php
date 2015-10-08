<?php
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">';
    echo '<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>';
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    
    session_start();
    
    $SERVER = 'us-cdbr-azure-central-a.cloudapp.net';
    $USER = 'bf7f0622e9427e';
    $PASS = '720ad0bb';
    $DATABASE = 'cs3380-pah9qd';
    
    $mylink = new mysqli($SERVER, $USER, $PASS, $DATABASE);
    $_SESSION['mylink'] = $mylink;
?>