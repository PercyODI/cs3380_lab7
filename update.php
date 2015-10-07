<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            
            //Set Primary Key Where String
            if ($_POST['searchingTable'] == "country") {
                $primaryKeyWhere = "code";
            }
            else if($_POST['searchingTable'] == "city") {
                $primaryKeyWhere = "id";
            }
            else if($_POST['searchingTable'] == "countrylanguage") {
                $primaryKeyWhere = "countrycode";
            }
            
            $stmt = null;
            $fields = array();
            $params = array();
            $rowData = array();
            
            if($stmt = $mylink->prepare("SELECT * FROM {$_POST['searchingTable']} WHERE $primaryKeyWhere = ?")) {
                $stmt->bind_param("s", $_POST['rowData']);
                $stmt->execute();
                $stmt->store_result();
                $metaData = $stmt->result_metadata();
                while($holder = $metaData->fetch_field()) {
                    $params[] = &$rowData[$holder->name];
                    $fields[] = $holder->name;
                };
                call_user_func_array(array($stmt, 'bind_result'), $params);
                
            }
            
        ?>
    </head>
    <body>
        <?php
            echo $_POST['searchingTable'];
            print_r("<br><hr><br>");
            $_POST['searchingTable'] != "countrylanguage" 
                ? print_r($_POST['rowData'])
                : print_r(unserialize($_POST['rowData']));
            print_r("<br><hr><br>");
            while($stmt->fetch()) {
                foreach($rowData as $dataPoint) {
                    echo $dataPoint . " - ";
                }
            }
            foreach($fields as $field) {
                echo $field . "<br>";
            }
        ?>
    </body>
</html>