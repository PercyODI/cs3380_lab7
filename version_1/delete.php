<?php
    include_once('database_and_functions.php');
    
    if(array_key_exists('cancelDel', $_POST) == false) {
        setSessionPk($_POST['pk']);
    } else {
        $_SESSION['pkSqlStr'] = $_POST['cancelDel'];
        unset($_POST['cancelDel']);
        unset($_SESSION['newID']);
    }
    
    echo "<script>";
    echo "console.log('cancelDel = ' + " . $_POST['cancelDel'] . ");";
    echo "</script>";
    
    $sql = "DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1";
    echo "<script>console.log($sql);</script>";
    
    
    
    if ($stmt = $mylink->prepare("DELETE FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']} LIMIT 1")) {
        $stmt->execute(); 
        $stmt->close();
        $_SESSION['message'] = "Record updated successfully";
    } else {
        $_SESSION['message'] = "Error updating record: " . $mylink->error;
    }
    
    
?>