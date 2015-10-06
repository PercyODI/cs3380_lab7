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
        ?>  
        
        <style>
            table, tr, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            
            td {
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                    <div class="form-group">
                        <div class="radio">
                            <label for="country">
                                <input type="radio" name="fromRadio" value="country" id="country"<?=is_selected("country")?>>
                                Country
                            </label>
                        </div>
                        <div class="radio">
                            <label for="city">
                                <input type="radio" name="fromRadio" value="City" id="city"<?=is_selected("City")?>> 
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
                            <label for="search">Search</label>
                            <input type="text" class="form-control" name="searchText" id="searchText" placeholder="Search...">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
                <table>
                    <?php
                        // print_r($mylink);
                        // $stmt = $mylink->prepare("SELECT * FROM city WHERE name='english'");
                        // print_r($stmt);
                        $results = 0;
                        // $stmt = $mylink->stmt_init();
                        if($stmt = $mylink->prepare("select l.countrycode, c.name from countrylanguage as l inner join country as c on c.code = l.countrycode WHERE language=?")) {
                            $stmt->bind_param("s", $_POST['searchText']);
                            $stmt->execute();
                            $stmt->bind_result($countrycode, $name);
                            while($stmt->fetch()) {
                                echo "<tr><td>$countrycode</td><td>$name</td></tr>";
                                $results++;
                            }
                            $stmt->close();
                        } else {
                            echo "<br>In Else :(";
                        }
                        
                        if ( false===$stmt ) {
                          die('prepare() failed: ' . htmlspecialchars($mylink->error));
                        }
                        mysqli_close($mylink);
                        
                    ?>
                </table>
                <?php echo "Number of Results: $results"; ?>
            </div>
        </div>
    </body>