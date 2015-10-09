<?php
    include_once('database_and_functions.php');
    
    if()
    setSessionPk($_POST['pk']);
    
    $sql = "DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1";
    echo $sql;
    
    if ($mylink->query("DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1") === TRUE) {
        $_SESSION['message'] = "Record updated successfully";
    } else {
        $_SESSION['message'] = "Error updating record: " . $mylink->error;
    }
    
    
?>