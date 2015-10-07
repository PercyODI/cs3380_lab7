<!-- Author:
      Pearse Hutson
      pah9qd
      14040826
-->

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <?php
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
            
            $SERVER = 'us-cdbr-azure-central-a.cloudapp.net';
            $USER = 'bf7f0622e9427e';
            $PASS = '720ad0bb';
            $DATABASE = 'cs3380-pah9qd';
            
            $mylink = new mysqli($SERVER, $USER, $PASS, $DATABASE);
            $_SESSION['mylink'] = $mylink;
            
            function is_selected($value) {
                if (isset($_POST['fromRadio'])) {
                    if ($value == $_POST['fromRadio']) {
                        echo " checked";
                    } else {
                        echo "";
                    }
                }
            }
            
            //Decide on Prepare Statement
            $tableData = array();
            $tableHeaders = array();
            $stmt = null;
            isset($_POST['fromRadio'])
                ? $searchingTable = $_POST['fromRadio']
                : $searchingTable = "city.name";
                
            isset($_POST['searchText'])
                ? $searchLike = $_POST['searchText'] . '%'
                : $searchLike = "";
                
            
            // if($stmt = $mylink->prepare("select country.code, country.name, city.name, countrylanguage.language 
            //                             from country, city, countrylanguage
            //                             where country.code = countrylanguage.countrycode
            //                                 AND country.code = city.countrycode
            //                                 AND $searchingTable LIKE ? 
            //                             ORDER BY $searchingTable")) {
            //     $stmt->bind_param("s", $searchLike);
            //     $stmt->execute();
            //     $stmt->bind_result($countrycode, $countryname, $cityname, $language);
            //     array_push($tableHeaders, "Update", "Delete", "Country Code", "Country Name", "City Name", "Language");
            //     $i = 0;
            //     while($stmt->fetch()) {
            //         $tableData[$i][] = $countrycode;
            //         $tableData[$i][] = $countryname;
            //         $tableData[$i][] = $cityname;
            //         $tableData[$i][] = $language;
            //         $i++;
            //     }
            //     $stmt->close();
            // } else {
            //     echo "<br>In Else :(";
            // }
            
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
                            <input type="text" class="form-control" name="searchText" id="searchText" placeholder="Search...">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
                <br>
                <table class="table table-striped">
                    <?php
                        foreach($tableHeaders as $header) {
                            echo "<th>$header</th>";
                        }
                        foreach ($tableData as $row) {
                            echo "\n\n<tr>";
                            echo "<form action='update.php' method='POST'>";
                            echo "<input type='hidden' name='searchingTable' value='$searchingTable'>";
                            echo "<input type='hidden' name='code' value='{$row[0]}'>";
                            echo "<td><button type='submit' name='searchingTable'>Update</button></td>";
                            echo "<td><button type='submit' name='searchingTable''>Delete</button></td>";
                            foreach ($row as $dataPoint) {
                                echo "<td>$dataPoint</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </table>
                <?php echo "Number of Results: " . count($tableData); ?>
            </div>
        </div>
    </body>