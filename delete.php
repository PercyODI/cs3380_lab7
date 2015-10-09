<?php
    include_once('database_and_functions.php');
    
    if(array_key_exists('cancelDel', $_POST) != false) {
        setSessionPk($_POST['pk']);
    } else {
        $_SESSION['pkSqlStr'] = $_POST['cancelDel'];
        unset($_POST['cancelDel']);
    }
    
    $sql = "DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1";
    echo $sql;
    
    if ($mylink->query("DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1") === TRUE) {
        $_SESSION['message'] = "Record updated successfully";
    } else {
        $_SESSION['message'] = "Error updating record: " . $mylink->error;
    }
    
    
?>