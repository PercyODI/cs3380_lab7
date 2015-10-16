<?php
include_once('header.php');

$selected_table = $_GET['table-input'];
$search_text = $_GET['search-input'] . '%';

// This function actually prints the requested data
function printTable($tableData, $pkField,  $table, $secondPkField = null) {
    if(empty($tableData)) {
        echo "No records found for search query";
        exit;
    }
    echo "<table class='table table-hover'>\n";
    echo "<tr>\n";
    echo "<th>Update</th><th>Delete</th>";
    foreach($tableData[0] as $header => $val) {
        echo "<th>$header</th>\n";
    }
    echo "</tr>\n";
    foreach($tableData as $row) {
        $serialPk = serialize(array("{$pkField}" => $row["{$pkField}"],  
            "{$secondPkField}" => !is_null($secondPkField) 
                ? $row["{$secondPkField}"] 
                : null,
            "Table" => $table));
        echo "<tr>\n";
        echo "<td><button type='button' class='btn btn-default table-btn update-btn' pk='$serialPk'>Update</button></td>";
        echo "<td><button type='button' class='btn btn-default table-btn delete-btn'>Delete</button></td>";
        foreach($row as $dataPoint) {
            echo "<td>$dataPoint</td>\n";
        }
        echo "</tr>\n";
    }
}

function showCityTable() {
    global $search_text;
    global $mylink;
    $stmt = null;
    // $tableHeaders = array("ID", "Name", "Country Code", "District", "Population");
    $tableData = array();
    
    if($stmt = $mylink->prepare("SELECT ID, Name, CountryCode, District, Population FROM city WHERE Name LIKE ?")) {
        $stmt->bind_param("s", $search_text);
        $stmt->execute();
        $stmt->bind_result($id, $name, $countrycode, $district, $population);
        while($stmt->fetch()) {
            $tableData[] = array("ID" => $id, "Name" => $name, "Country Code" => $countrycode, "District" => $district, "Population" => $population);
        }
    }
    
    printTable($tableData, "ID", "city");
}

function showCountryTable() {
    global $search_text;
    global $mylink;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("SELECT Code, Name, Continent, Region, SurfaceArea, IndepYear, Population, LifeExpectancy, GNP, GNPOld, LocalName, GovernmentForm, HeadOfState, Capital, Code2 FROM country WHERE Name LIKE ?")) {
        $stmt->bind_param("s", $search_text);
        $stmt->execute();
        $stmt->bind_result($code, $name, $continent, $region, $surfacearea, $indepyear, $population, $lifeexpectancy, $gnp, $gnpold, $localname, $governmentform, $headofstate, $capital, $code2);
        while($stmt->fetch()) {
            $tableData[] = array("Code" => $code, "Name" => $name, "Continent" => $continent, 
                "Region" => $region, "Surface Area" => $surfacearea, "Independence Year" => $indepyear, 
                "Population" => $population, "Life Expectancy" => $lifeexpectancy, "GNP" => $gnp,
                "GNP Old" => $gnpold, "Local Name" => $localname, "Government Form" => $governmentform, 
                "Head of State" => $headofstate, "Capital" => $capital, "Code 2" => $code2);
        }
    }
    
    printTable($tableData, "Code", "country");
}

function showLanguageTable() {
    global $search_text;
    global $mylink;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("SELECT CountryCode, Language, IsOfficial, Percentage FROM countrylanguage WHERE Language LIKE ?")) {
        $stmt->bind_param("s", $search_text);
        $stmt->execute();
        $stmt->bind_result($CountryCode, $Language, $IsOfficial, $Percentage);
        while($stmt->fetch()) {
            $tableData[] = array("Country Code" => $CountryCode, "Language" => $Language, "Is Offical?" => $IsOfficial, "Percentage" => $Percentage);
        }
    }
    
    printTable($tableData, "Country Code", "countrylanguage", "Language");
}

switch ($selected_table) {
    case "city":
        showCityTable();
        break;
    case "country":
        showCountryTable();
        break;
    case "language":
        showLanguageTable();
        break;
    default:
        echo "Error! Error!";
}