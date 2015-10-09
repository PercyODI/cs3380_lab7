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
            
            if(isset($_SESSION['table']) == false) {
                isset($_POST['fromRadio'])
                    ? $_SESSION['table'] = $_POST['fromRadio']
                    : $_SESSION['table'] = "city";
            } else {
                if(isset($_POST['fromRadio'])) {
                    $_SESSION['table'] = $_POST['fromRadio'];
                }
            }
            
            if(isset($_SESSION['search']) == false) {
                if(isset($_POST['searchText'])) {
                    $_SESSION['search'] = $_POST['searchText'];
                    $searchLike = $_SESSION['search'] . '%';
                } else {
                    $searchLike = " ";
                }
            } else {
                if(isset($_POST['searchText'])) {
                    $_SESSION['search'] = $_POST['searchText'];
                }
                
                $searchLike = $_SESSION['search'] . '%';
            }
            
            
            showTable();
            
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
        
        <script>
            $(document).ready(function() {
                $('.delete-btn').click(function() {
                    if(confirm("Are you sure you want to delete " + $(this).attr('pk'))) {
                        $.post("delete.php", {pk: $(this).attr('pk')}).done(function(data) {
                            location.reload();
                        });
                    }
                });
            });
        </script>
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
                            <input type="text" class="form-control" name="searchText" id="searchText" placeholder="Search..." value='<?=$_SESSION['search'];?>'>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                    <a class="btn btn-default pull-right" href="new_city.php" role="button">Insert City</a> 
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
                        echo "<input type='hidden' name='pk' value='" . findPrimaryKey($_SESSION['table'], $row) . "'>\n";
                        echo "<td><button type='submit' name='update'>Update</button></td>\n";
                        echo "</form>\n";
                        // echo "<form action='delete.php' method='POST'>\n";
                        // echo "<input type='hidden' name='pk' value='" . findPrimaryKey($_SESSION['table'], $row) . "'>\n";
                        echo "<td><button type='submit' name='delete' class='delete-btn' pk='" . findPrimaryKey($_SESSION['table'], $row) . "'>Delete</button></td>\n";
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