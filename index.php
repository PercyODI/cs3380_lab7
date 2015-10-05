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
          error_reporting(-1);
        
          $SERVER = 'us-cdbr-azure-central-a.cloudapp.net';
          $USER = 'bf7f0622e9427e';
          $PASS = '720ad0bb';
          $DATABASE = 'cs3380-pah9qd';
          
          $mylink = new mysqli($SERVER, $USER, $PASS, $DATABASE);
          $_SESSION['mylink'] = $mylink;
          
          
        ?>  
        
        <style>
            table {
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!--<div class="row">-->
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                    <div class="form-group">
                        <div class="radio">
                            <label for="country">
                                <input type="radio" name="fromRadio" value="country" id="country">
                                Country
                            </label>
                        </div>
                        <div class="radio">
                            <label for="city">
                                <input type="radio" name="fromRadio" value="city" id="city"> 
                                City
                            </label>
                        </div>
                        <div class="radio">
                            <label for="language">
                                <input type="radio" name="fromRadio" value="language" id="language">
                                Language
                            </label>
                        </div>  
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="searchText" placeholder="Search...">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
                
                <?php
                    echo "Hello?";
                    // echo $_POST['fromRadio'];
                    // print_r($mylink);
                    $stmt = $mylink->prepare("SELECT * FROM ? WHERE name=?");
                    print_r($stmt);
                    $results = null;
                    if($stmt = $mylink->prepare("SELECT * FROM ? WHERE name=?")) {
                        echo "<br>In If!<br>";
                        $stmt->bind_param("ss", $_POST['fromRadio'], $_POST['searchText']);
                        $stmt->execute();
                        $stmt->bind_result($results);
                        $stmt->fetch();
                        print_r($results);
                        $stmt->close();
                    }
                    mysqli_close($mylink);
                ?>
                <table>
                    
                </table>
                
            </div>
        </div>
    </body>