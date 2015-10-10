<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            // $sql = "UPDATE city SET 
            //             Name = '{$_POST['Name']}', 
            //             CountryCode = '{$_POST['CountryCode']}', 
            //             District = '{$_POST['District']}', 
            //             Population = '{$_POST['Population']}'
            //         WHERE ID = {$_SESSION['newID']}";
            
            // print_r($_POST);
            // echo $sql;
            
            if ($stmt = $mylink->prepare("UPDATE city SET 
                                            Name = ?, 
                                            CountryCode = ?, 
                                            District = ?, 
                                            Population = ?
                                        WHERE ID = ?")) {
                $stmt->bind_param('sssdi', 
                    $_POST['Name'],
                    $_POST['CountryCode'],
                    $_POST['District'],
                    $_POST['Population'],
                    $_SESSION['newID']);
                $stmt->execute();
                $stmt->close();
                header('Location: index.php');
                unset($_SESSION['newID']);
            } else {
                $_SESSION['message'] = "Error updating record: " . $mylink->error;
                header('Location: new_city.php');
            }
        ?>
    </head>
</html>