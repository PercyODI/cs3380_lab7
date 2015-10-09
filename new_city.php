<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            
            //Find
            $mylink->query("INSERT INTO city (CountryCode) VALUES ((select code from country limit 1))");
            $newID = $mylink->insert_id;
            
            $stmt = null;
            $fields = array();
            $params = array();
            $rowData = array();
            
            if($stmt = $mylink->prepare("SELECT * FROM city WHERE ID = $newID")) {
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
            
            //Find list of CountryCodes
            $codeArr = array();
            $codeQy = $mylink->query("SELECT code FROM country");
            while ($code = $codeQy->fetch_row()) {
                $codeArr[] = $code[0];
            }
            
            print_r($codeArr);
            
            function inputExtra($fieldName) {
                $extraStr = "";
                if($fieldName == "ID") {
                    $extraStr .= "disabled ";
                }
                
                if($fieldName == "Population") {
                    $extraStr .= "type='number' min='0' max='99999999999'";
                } else {
                    $extraStr .= "type = 'text' ";
                }
                
                return $extraStr;
            }
        ?>
    </head>
    <body>
        <div class="container">
        <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
        <div class="well"><h2>Insert New City</h2></div>
        <form class="form-horizontal" action="new_city_action.php" method="POST">
            
            <?php
                if(isset($_SESSION['message'])) {
                    echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                foreach($fields as $i => $field) {
                    echo "<div class='form-group'>\n";
                    echo "<label for='$field' class='col-sm-2'>$field</label><br>\n";
                    echo "<div class='col-sm-11 col-sm-offset-1'>\n";
                    if($field != 'Countrycode') {
                        echo "<input class='form-control' id='$field' name='$field' value='" . $rowData[$field] . "' " . inputExtra($field) . ">\n";
                    } else {
                        echo "<select class='form-control'>\n";
                        foreach($codeArr as $code) {
                            echo "<option>$code</option>\n";
                        }
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