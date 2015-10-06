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
            
            function is_selected($name) {
                if (isset($_POST['fromRadio'])) {
                    if ($name == $_POST['fromRadio']) {
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
            $whereFrom = $_POST['fromRadio'];
            // "select l.countrycode, c.name as country, city.name, l.language 
            // from (
            //     select c.name from countrylanguage as l 
            //     inner join country as c 
            //     on c.code = l.countrycode 
            // ) as languageCountry inner join (
            //     select * from city
            //     inner join country as c
            //     on c.code = city.countrycode 
            // ) as cityCountry
            // on languageCountry.co
            // WHERE country LIKE ?"
            if($stmt = $mylink->prepare("select country.code, country.name, city.name, countrylanguage.language 
                                        from country, city, countrylanguage
                                        where country.code = countrylanguage.countrycode
                                            AND country.code = city.countrycode
                                            AND $whereFrom LIKE ? ")) {
                $searchLike = $_POST['searchText'] . '%';
                $stmt->bind_param("s", $searchLike);
                $stmt->execute();
                $stmt->bind_result($countrycode, $countryname, $cityname, $language);
                array_push($tableHeaders, "Country Code", "Country Name", "City Name", "Language");
                $i = 0;
                while($stmt->fetch()) {
                    $tableData[$i][] = $countrycode;
                    $tableData[$i][] = $countryname;
                    $tableData[$i][] = $cityname;
                    $tableData[$i][] = $language;
                    $i++;
                }
                $stmt->close();
            } else {
                echo "<br>In Else :(";
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
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="form-inline">
                    <div class="form-group">
                        <div class="radio">
                            <label for="country">
                                <input type="radio" name="fromRadio" value="country.name" id="country"<?=is_selected("country")?>>
                                Country
                            </label>
                        </div>
                        <div class="radio">
                            <label for="city">
                                <input type="radio" name="fromRadio" value="city.name" id="city"<?=is_selected("city")?>> 
                                City
                            </label>
                        </div>
                        <div class="radio">
                            <label for="language">
                                <input type="radio" name="fromRadio" value="countrylanguage.language" id="language"<?=is_selected("language")?>>
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
                            echo "<tr>";
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