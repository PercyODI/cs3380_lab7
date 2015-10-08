<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            foreach($_POST as $key => $val) {
                echo $key . " => " . $val . "<br>";
            }
            
            $insertValues = null;
        ?>
    </head>
</html>