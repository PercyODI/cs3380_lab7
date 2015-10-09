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
            // echo $sql;
            
            if ($mylink->query($sql) === TRUE) {
                header('Location: index.php');
            } else {
                $_SESSION['message'] = "Error updating record: " . $mylink->error;
                header('Location: update.php');
            }
            
            
        ?>
    </head>
</html>