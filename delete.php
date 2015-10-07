<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
        ?>
    </head>
    <body>
        <?php
            echo $_POST['searchingTable'];
            echo "<br><hr><br>";
            print_r(unserialize($_POST['rowData']));
        ?>
    </body>
</html>