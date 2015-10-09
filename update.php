<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            
            // Primary Key Array
            if(isset($_POST['pk'])) {
                setSessionPk($_POST['pk']);
            }
            
            $stmt = null;
            $fields = array();
            $params = array();
            $rowData = array();
            
            if($stmt = $mylink->prepare("SELECT * FROM {$_SESSION['table']} WHERE {$_SESSION['pkSqlStr']}")) {
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
            
            if(isset($rowData['Percentage'])) {
                $rowData['Percentage'] = round($rowData['Percentage'], 1);
            }
                
            
            if($_SESSION['table'] == 'country') {
                $editableFields = array("LocalName", "GovernmentForm", "IndepYear", "Popluation");
            }
            else if($_SESSION['table'] == 'city') {
                $editableFields = array("Population", "District");
            }
            else if($_SESSION['table'] == 'countrylanguage') {
                $editableFields = array("IsOfficial", "Percentage");
            } else {
                $editableFields = array();
            }
            
            function inputExtra($field) {
                global $editableFields;
                $extraStr = "";
                
                if (!in_array($field, $editableFields)) {
                    $extraStr .= "disabled ";
                }
                
                if($field == "Name") {
                    $extraStr .= "maxlength='35' ";
                }
                
                if($field == "District") {
                    $extraStr .= "maxlength='20' ";
                }
                
                if($field == "LocalName") {
                    $extraStr .= "maxlength='45' ";
                }
                
                if($field == "GovernmentForm") {
                    $extraStr .= "maxlength='45' ";
                }
                
                if($field == "IndepYear") {
                    $extraStr .= "type='number' min='0' max='32767' ";
                }
                
                if($field == "Population") {
                    $extraStr .= "type='number' min='0' max='2147483647' ";
                } 
                
                if($field == "Percentage") {
                    $extraStr .= "type='number' min='0' max='100' step='0.1' ";
                }
                
                return $extraStr;
            }
            
            function officalChecked($field, $torf) {
                global $rowData;
                if($rowData[$field] == $torf) {
                    return " selected";
                }
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
        <div class="well"><h2>Update <?=$_SESSION['table']?></h2></div>
        <form class="form" action="update_action.php" method="POST">
            
            <?php
                if(isset($_SESSION['message'])) {
                    echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                foreach($fields as $i => $field) {
                    echo "<div class='form-group'>\n";
                    echo "<label for='$field' class='col-sm-2'>$field</label><br>\n";
                    echo "<div class='col-sm-11 col-sm-offset-1'>\n";
                    if($field == "IsOfficial") {
                        echo "<select class='form-control' name='$field''>";
                        echo "<option class='form-control' value='T'" . officalChecked($field, "T") . ">True</option>\n";
                        echo "<option class='form-control' value='F'" . officalChecked($field, "F") . ">False</option>\n";
                        echo "</select>";
                    } else {
                        echo "<input class='form-control' id='$field' name='$field' value='" . $rowData[$field] . "' " . inputExtra($field) . ">\n";

                    }
                    echo "</div>\n";
                    echo "</div>\n";
                }
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