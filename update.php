<!DOCTYPE html>
<html>
    <head>
        <?php
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
        ?>
    </head>
    <body>
        <?php
            echo $_POST['searchingTable'];
            print_r("<br><hr><br>");
            print_r(unserialize($_POST['rowData']));
        ?>
    </body>
</html>