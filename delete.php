<?php
    include_once('database_and_functions.php');
    
    setSessionPk($_POST['pk']);
    
    print_r($_SESSION['pkArray']);
    
    $sql = "DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1";
    echo $sql;
    
    if ($mylink->query("DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1") === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $mylink->error;
    }
    
    
?>