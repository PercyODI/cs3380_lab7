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
                ? $searchingTable = $_POST['fromRadio']
                : $searchingTable = "city";
                
            isset($_POST['searchText'])
                ? $searchLike = $_POST['searchText'] . '%'
                : $searchLike = " ";
                
            function showCity() {
                global $mylink;
                global $tableHeaders;
                global $searchLike;
                global $stmt;
                global $tableData;
                
                if($stmt = $mylink->prepare("select id, name, countrycode, district, population FROM city WHERE name LIKE ? ORDER BY name")) {
                    $stmt->bind_param("s", $searchLike);
                    $stmt->execute();
                    $stmt->bind_result($id, $name, $countrycode, $district, $population);
                    $i = 0;
                    while($stmt->fetch()) {
                        $tableData[$i][] = $id;
                        $tableData[$i][] = $name;
                        $tableData[$i][] = $countrycode;
                        $tableData[$i][] = $district;
                        $tableData[$i][] = $population;
                        $i++;
                    }
                    array_push($tableHeaders, "Update", "Delete", "ID", "Name", "Country Code", "District", "Population");
                    
                    if ( false===$stmt ) {
                      die('prepare() failed: ' . htmlspecialchars($mylink->error));
                    }
                    $stmt->close();
                }
            }
            
            function showCountry() {
                global $mylink;
                global $tableHeaders;
                global $searchLike;
                global $stmt;
                global $tableData;
                
                if($stmt = $mylink->prepare("select code, name, continent, 
                    region, surfacearea, indepyear, population, lifeexpectancy, 
                    gnp, gnpold, localname, governmentform, headofstate, 
                    capital, code2 FROM country WHERE name LIKE ? ORDER BY name")) {
                    $stmt->bind_param("s", $searchLike);
                    $stmt->execute();
                    $stmt->bind_result($code, $name, $continent, $region, 
                        $surfacearea, $indepyear, $population, $lifeexpectancy, 
                        $gnp, $gnpold, $localname, $governmentform, $headofstate, 
                        $capital, $code2);
                    $i = 0;
                    while($stmt->fetch()) {
                        $tableData[$i++] = array($code, $name, $continent, $region, 
                        $surfacearea, $indepyear, $population, $lifeexpectancy, 
                        $gnp, $gnpold, $localname, $governmentform, $headofstate, 
                        $capital, $code2);
                    }
                    array_push($tableHeaders, "Update", "Delete", "code", "name", "continent", "
                    region", "surfacearea", "indepyear", "population", "lifeexpectancy", 
                    "gnp", "gnpold", "localname", "governmentform", "headofstate", 
                    "capital", "code2");
                    if ( false===$stmt ) {
                      die('prepare() failed: ' . htmlspecialchars($mylink->error));
                    }
                    $stmt->close();
                }
            }
            
            function showLanguage() {
                global $mylink;
                global $tableHeaders;
                global $searchLike;
                global $stmt;
                global $tableData;
                
                if($stmt = $mylink->prepare("select CountryCode, Language, IsOfficial, Percentage FROM countrylanguage WHERE language LIKE ? ORDER BY language")) {
                    
                    $stmt->bind_param("s", $searchLike);
                    $stmt->execute();
                    $stmt->bind_result($countrycode, $language, $isofficial, $percentage);
                    $i = 0;
                    while($stmt->fetch()) {
                        $tableData[$i++] = array($countrycode, $language, $isofficial, $percentage);
                    }
                    array_push($tableHeaders, "Update", "Delete", "countrycode", "language", "isofficial", "percentage");
                    if ( false===$stmt ) {
                      die('prepare() failed: ' . htmlspecialchars($mylink->error));
                    }
                    $stmt->close();
                }
            }
            
            function findPrimaryKey($table, $row) {
                if ($table == 'city') {
                    return $row[0];
                } 
                else if ($table == 'country') {
                    return $row[0];
                }
                else if ($table == 'countrylanguage') {
                    return serialize(array_slice($row, 0, 2));
                } else {
                    return "Error in findPrimaryKey()!!";
                }
            }
                
            switch ($searchingTable) {
                case 'city':
                    showCity();
                    break;
                case 'country':
                    showCountry();
                    break;
                case 'countrylanguage':
                    showLanguage();
                    break;
                default:
                    
            }
            
            //Check for errors and close link
            if ( false===$stmt ) {
              die('prepare() failed: ' . htmlspecialchars($mylink->error));
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
                        echo "<input type='hidden' name='searchingTable' value='$searchingTable'>\n";
                        echo "<input type='hidden' name='rowData' value='" . findPrimaryKey($searchingTable, $row) . "'>\n";
                        echo "<td><button type='submit' name='update'>Update</button></td>\n";
                        echo "</form>\n";
                        echo "<form action='delete.php' method='POST'>\n";
                        echo "<input type='hidden' name='searchingTable' value='$searchingTable'>\n";
                        echo "<input type='hidden' name='rowData' value='" . findPrimaryKey($searchingTable, $row) . "'>\n";
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