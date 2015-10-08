<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            
            //Set Where String
            if ($_POST['searchingTable'] == "country") {
                $whereStr = "code = '" . $_POST['rowData'] . "'";
            }
            else if($_POST['searchingTable'] == "city") {
                $whereStr = "id = " . $_POST['rowData'];
            }
            else if($_POST['searchingTable'] == "countrylanguage") {
                $rowDataArr = unserialize($_POST['rowData']);
                $whereStr = "countrycode = '" . $rowDataArr[0] . "' and language = '" . $rowDataArr[1] . "'";
            } else {
                echo "Error is Set Where String!";
            }
            
            $stmt = null;
            $fields = array();
            $params = array();
            $rowData = array();
            
            if($stmt = $mylink->prepare("SELECT * FROM {$_POST['searchingTable']} WHERE $whereStr")) {
                $stmt->execute();
                $stmt->store_result();
                $metaData = $stmt->result_metadata();
                while($holder = $metaData->fetch_field()) {
                    $params[] = &$rowData[$holder->name];
                    $fields[] = $holder->name;
                };
                call_user_func_array(array($stmt, 'bind_result'), $params);
                $stmt->fetch();
            }
            
        ?>
        
        <style>
            .well {
                text-align: center;
            }
        </style>
        
       
    </head>
    <body>
        <div class="container">
        <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
        <div class="well"><h2>Update <?=$_POST['searchingTable']?></h2></div>
        <form class="form-horizontal" action="update_action.php" method="POST">
            
            <?php
                foreach($fields as $i => $field) {
                    echo "<div class='form-group'>\n";
                    echo "<label for='$field' class='col-sm-2'>$field</label><br>\n";
                    echo "<div class='col-sm-11 col-sm-offset-1'>\n";
                    echo "<input type='text' class='form-control' id='$field' name='$field' value='" . $rowData[$field] . "'>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
                // Show all data values
                // foreach($rowData as $dataPoint) {
                //     echo $dataPoint . " - ";
                // }
                
                // Show all field names
                // foreach($fields as $field) {
                //     echo $field . "<br>";
                // }
            ?>
            <div class="btn-toolbar">
                <a href="http://cs3380-pah9qd.cloudapp.net/lab7/index.php" type="button" class="btn btn-default pull-right" id="cancel-btn" role="button">Cancel</a>
                <button type="reset" class="btn btn-default pull-right">Reset</button>
                <button type="submit" class="btn btn-default pull-right">Save</button>
            </div>
        </form>
        </div></div></div>
    </body>
</html>