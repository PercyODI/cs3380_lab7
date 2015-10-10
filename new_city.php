<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once('header.php');
            
            // Create new empty row
            if(isset($_SESSION['newID']) == false) {
                $mylink->query("INSERT INTO city (CountryCode) VALUES ((select code from country limit 1))");
                $newID = $mylink->insert_id;
                $_SESSION['newID'] = $newID;
            } else {
                $newID = $_SESSION['newID'];
            }
            
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
            $stmt = $mylink->prepare("SELECT code, name FROM country ORDER BY name");
            $stmt->execute();
            $stmt->bind_result($code, $name);
            while ($stmt->fetch()) {
                $codeArr[$code] = $name;
            }
            
            function inputExtra($fieldName) {
                $extraStr = "";
                if($fieldName == "ID") {
                    $extraStr .= "disabled id='ID' ";
                }
                
                if($fieldName == "Name") {
                    $extraStr .= "maxlength='35' ";
                }
                
                if($fieldName == "District") {
                    $extraStr .= "maxlength='20' ";
                }
                
                if($fieldName == "Population") {
                    $extraStr .= "type='number' min='0' max='2147483647' ";
                } else {
                    $extraStr .= "type = 'text' ";
                }
                
                return $extraStr;
            }
        ?>
        
        <style>
            .well {
                text-align: center;
            }
        </style>
        
        <script>
            $(document).ready(function () {
                $('#cancel-btn').click(function(e) {
                    // confirm("Are you watching?");
                    // e.preventDefault();
                    // console.log("ID = " + $('#ID').val());
                    var cancelStr = "ID = " + $('#ID').val();
                    $.post("delete.php", {cancelDel: cancelStr}).done(function(data) {
                        // console.log(data);
                    });
                });
            });
        </script>
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
                    if($field != 'CountryCode') {
                        echo "<input class='form-control' id='$field' name='$field' value='" . $rowData[$field] . "' " . inputExtra($field) . ">\n";
                    } else {
                        echo "<select class='form-control' name='$field'>\n";
                        foreach($codeArr as $key => $val) {
                            echo "<option value='$key'>$val</option>\n";
                        }
                        echo "</select>";
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