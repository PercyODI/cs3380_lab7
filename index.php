<!-- Author:
      Pearse Hutson
      pah9qd
      14040826
-->

<!DOCTYPE html>
<html>
    <head>
        
        
        <?php
            include_once('header.php');
            
            //Pre-selected the previously selected radio button
            function is_selected($value) {
                if (isset($_POST['fromRadio'])) {
                    if ($value == $_POST['fromRadio']) {
                        echo " checked";
                    } else {
                        echo "";
                    }
                } else {
                    if ($value == "country") {
                        echo " checked";
                    }
                }
            }
            
            function searchValue() {
                if (isset($_POST['searchText'])) {
                    echo " value='" . $_POST['searchText'] . "'";
                } else {
                    echo "";
                }
            }
            
            //Decide on Prepare Statement
            $tableData = array();
            $tableHeaders = array();
            $stmt = null;
            isset($_POST['fromRadio'])
                ? $_SESSION['table'] = $_POST['fromRadio']
                : $_SESSION['table'] = "city";
                
            isset($_POST['searchText'])
                ? $searchLike = $_POST['searchText'] . '%'
                : $searchLike = " ";
                

                
            switch ($_SESSION['table']) {
                case 'city':
                    showTable();
                    break;
                case 'country':
                    showTable();
                    break;
                case 'countrylanguage':
                    showTable();
                    break;
                default:
                    
            }
            
            mysqli_close($mylink);
        ?>  
        
        <style>
            /*table, tr, td {*/
            /*    border: 1px solid black;*/
            /*    border-collapse: collapse;*/
            /*}*/
            
            /*td {*/
            /*    padding: 5px;*/
            /*}*/
            
            .radio {
                margin-right: 8px;
            }
            
            .container {
                margin-top: 8px;
            }
            
            /*.table-cust {*/
            /*    table-layout: fixed;*/
            /*    margin: auto;*/
            /* }*/
             
            /* .table-cust th, .table-cust td {*/
            /*     width: 75px;*/
            /*     overflow: hidden;*/
            /* }*/
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="form-inline">
                    <div class="form-group">
                        <div class="radio">
                            <label for="country">
                                <input type="radio" name="fromRadio" value="country" id="country"<?=is_selected("country")?>>
                                Country
                            </label>
                        </div>
                        <div class="radio">
                            <label for="city">
                                <input type="radio" name="fromRadio" value="city" id="city"<?=is_selected("city")?>> 
                                City
                            </label>
                        </div>
                        <div class="radio">
                            <label for="language">
                                <input type="radio" name="fromRadio" value="countrylanguage" id="language"<?=is_selected("countrylanguage")?>>
                                Language
                            </label>
                        </div>  
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchText" id="searchText" placeholder="Search..."<?=searchValue();?>>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
            <table class="table table-condensed table-cust">
                <?php
                    foreach($tableHeaders as $header) {
                        echo "<th>$header</th>";
                    }
                    foreach ($tableData as $row) {
                        echo "\n\n<tr>\n";
                        echo "<form action='update.php' method='POST'>\n";
                        echo "<input type='hidden' name='searchingTable' value='" . $_SESSION['table'] . "'>\n";
                        echo "<input type='hidden' name='pk' value='" . findPrimaryKey($_SESSION['table'], $row) . "'>\n";
                        echo "<td><button type='submit' name='update'>Update</button></td>\n";
                        echo "</form>\n";
                        echo "<form action='delete.php' method='POST'>\n";
                        echo "<input type='hidden' name='searchingTable' value='" . $_SESSION['table'] . "'>\n";
                        echo "<input type='hidden' name='pk' value='" . findPrimaryKey($_SESSION['table'], $row) . "'>\n";
                        echo "<td><button type='submit' name='delete'>Delete</button></td>\n";
                        echo "</form>\n";
                        foreach ($row as $dataPoint) {
                            echo "<td>$dataPoint</td>";
                        }
                        echo "</tr>\n";
                    }
                ?>
            </table>
            <?php echo "Number of Results: " . count($tableData); ?>
    </body>