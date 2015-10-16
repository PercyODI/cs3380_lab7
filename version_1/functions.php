<?php
    function showTable() {
        global $mylink;
        global $tableHeaders;
        global $searchLike;
        global $stmt;
        global $tableData;
        
        $params = array();
        $rowData = array();
        
        if ($_SESSION['table'] == 'city') {
            $searchWhere = 'name';
        }
        elseif ($_SESSION['table'] == 'country') {
            $searchWhere = 'name';
        }
        if ($_SESSION['table'] == 'countrylanguage') {
            $searchWhere = 'language';
        }
        
        if ($stmt = $mylink->prepare("SELECT * FROM {$_SESSION['table']} WHERE $searchWhere LIKE ? ORDER BY $searchWhere")) {
            $stmt->bind_param("s", $searchLike);
            $stmt->execute();
            $stmt->store_result();
            $metaData = $stmt->result_metadata();
            
            while($holder = $metaData->fetch_field()) {
                $params[] = &$rowData[$holder->name];
                $tableHeaders[] = $holder->name;
            };
            
            call_user_func_array(array($stmt, 'bind_result'), $params);
            
            $i = 0;
            while ($stmt->fetch()) {
                //Serialize is used to make a copy of the array
                //Otherwise the $rowData is passed by reference,
                //Creating issues
                $strArray = serialize($rowData);
                $tableData[] = unserialize($strArray);
            }
            if ( false===$stmt ) {
              die('prepare() failed: ' . htmlspecialchars($mylink->error));
            }
            $stmt->close();
        }
        
        array_unshift($tableHeaders, "Update", "Delete");
    }
    
    // // Obsolete. Replaced by showTable()    
    // function showCity() {
    //     global $mylink;
    //     global $tableHeaders;
    //     global $searchLike;
    //     global $stmt;
    //     global $tableData;
        
    //     if($stmt = $mylink->prepare("select id, name, countrycode, district, population FROM city WHERE name LIKE ? ORDER BY name")) {
    //         $stmt->bind_param("s", $searchLike);
    //         $stmt->execute();
    //         $stmt->bind_result($id, $name, $countrycode, $district, $population);
    //         $i = 0;
    //         while($stmt->fetch()) {
    //             $tableData[$i][] = $id;
    //             $tableData[$i][] = $name;
    //             $tableData[$i][] = $countrycode;
    //             $tableData[$i][] = $district;
    //             $tableData[$i][] = $population;
    //             $i++;
    //         }
    //         array_push($tableHeaders, "Update", "Delete", "ID", "Name", "Country Code", "District", "Population");
            
    //         if ( false===$stmt ) {
    //           die('prepare() failed: ' . htmlspecialchars($mylink->error));
    //         }
    //         $stmt->close();
    //     }
    // }
    
    // // Obsolete. Replaced by showTable()  
    // function showCountry() {
    //     global $mylink;
    //     global $tableHeaders;
    //     global $searchLike;
    //     global $stmt;
    //     global $tableData;
        
    //     if($stmt = $mylink->prepare("select code, name, continent, 
    //         region, surfacearea, indepyear, population, lifeexpectancy, 
    //         gnp, gnpold, localname, governmentform, headofstate, 
    //         capital, code2 FROM country WHERE name LIKE ? ORDER BY name")) {
    //         $stmt->bind_param("s", $searchLike);
    //         $stmt->execute();
    //         $stmt->bind_result($code, $name, $continent, $region, 
    //             $surfacearea, $indepyear, $population, $lifeexpectancy, 
    //             $gnp, $gnpold, $localname, $governmentform, $headofstate, 
    //             $capital, $code2);
    //         $i = 0;
    //         while($stmt->fetch()) {
    //             $tableData[$i++] = array($code, $name, $continent, $region, 
    //             $surfacearea, $indepyear, $population, $lifeexpectancy, 
    //             $gnp, $gnpold, $localname, $governmentform, $headofstate, 
    //             $capital, $code2);
    //         }
    //         array_push($tableHeaders, "Update", "Delete", "code", "name", "continent", "
    //         region", "surfacearea", "indepyear", "population", "lifeexpectancy", 
    //         "gnp", "gnpold", "localname", "governmentform", "headofstate", 
    //         "capital", "code2");
    //         if ( false===$stmt ) {
    //           die('prepare() failed: ' . htmlspecialchars($mylink->error));
    //         }
    //         $stmt->close();
    //     }
    // }
    
    // // Obsolete. Replaced by showTable()  
    // function showLanguage() {
    //     global $mylink;
    //     global $tableHeaders;
    //     global $searchLike;
    //     global $stmt;
    //     global $tableData;
        
    //     if($stmt = $mylink->prepare("select CountryCode, Language, IsOfficial, Percentage FROM countrylanguage WHERE language LIKE ? ORDER BY language")) {
            
    //         $stmt->bind_param("s", $searchLike);
    //         $stmt->execute();
    //         $stmt->bind_result($countrycode, $language, $isofficial, $percentage);
    //         $i = 0;
    //         while($stmt->fetch()) {
    //             $tableData[$i++] = array($countrycode, $language, $isofficial, $percentage);
    //         }
    //         array_push($tableHeaders, "Update", "Delete", "countrycode", "language", "isofficial", "percentage");
    //         if ( false===$stmt ) {
    //           die('prepare() failed: ' . htmlspecialchars($mylink->error));
    //         }
    //         $stmt->close();
    //     }
    // }
    
    function findPrimaryKey($table, $row) {
        if ($table == 'city') {
            return serialize(array('ID' => $row['ID']));
        } 
        elseif ($table == 'country') {
            return serialize(array('Code' => $row['Code']));
        }
        elseif ($table == 'countrylanguage') {
            return serialize(array('CountryCode' => $row['CountryCode'], 'Language' => $row['Language']));
        } else {
            return "Error in findPrimaryKey()!!";
        }
    }
    
    function is_selected($value) {
        if (isset($_SESSION['table'])) {
            if ($value == $_SESSION['table']) {
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
    
    //Obsolete
    function searchValue() {
        if (isset($_POST['searchText'])) {
            echo " value='" . $_POST['searchText'] . "'";
        } else {
            echo "";
        }
    }
    
    function setSessionPk($serialPk) {
        $_SESSION['pkArray'] = unserialize($serialPk);
        
        $_SESSION['pkSqlStr'] = "";
        foreach($_SESSION['pkArray'] as $key => $value) {
            $_SESSION['pkSqlStr'] .= "$key = '$value'";
            end($_SESSION['pkArray']);
            if($key != key($_SESSION['pkArray'])) {
                $_SESSION['pkSqlStr'] .= " AND ";
            }
        }
    }
?>