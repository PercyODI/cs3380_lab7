<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            $sql = "UPDATE " . $_SESSION['table'] . " SET ";
            foreach($_POST as $key => $val) {
                if($val != null) {
                    $sql .= $key . " = '" . $val . "'";
                } else {
                    $sql .= $key . " = NULL";
                }
                end($_POST);
                if ($key != key($_POST)) {
                    $sql .= ", ";
                }
            }
            $sql .= " WHERE " . $_SESSION['pkSqlStr'];
            echo $sql;
            
            // echo $sql;
            
            // if ($mylink->query($sql) === TRUE) {
            //     echo "Record updated successfully";
            // } else {
            //     echo "Error updating record: " . $mylink->error;
            // }
            
            
        ?>
    </head>
</html>