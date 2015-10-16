<?php
include_once('header.php');

$pkArray = unserialize($_GET['pk']);
// print_r($pkArray);
// echo "<br><hr><br>";

function displayUpdate($tableData, $editableFields) {
    echo "<form>\n";
    foreach($tableData as $field => $val) {
        <div class="">
    }
}

function showCityUpdate() {
    global $mylink;
    global $pkArray;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("SELECT ID, Name, CountryCode, District, Population FROM city WHERE ID = ? LIMIT 1")) {
        $stmt->bind_param("s", $pkArray['ID']);
        $stmt->execute();
        $stmt->bind_result($id, $name, $countrycode, $district, $population);
        if($stmt->fetch()) {
            $tableData = array("ID" => $id, "Name" => $name, "Country Code" => $countrycode, "District" => $district, "Population" => $population);
        }
    }
    $editableFields = array("Population", "District");
    displayUpdate($tableData, $editableFields);
}

function showCountryUpdate() {
    global $mylink;
    global $pkArray;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("SELECT Code, Name, Continent, Region, SurfaceArea, IndepYear, Population, LifeExpectancy, GNP, GNPOld, LocalName, GovernmentForm, HeadOfState, Capital, Code2 FROM country WHERE code = ? LIMIT 1")) {
        $stmt->bind_param("s", $pkArray['Code']);
        $stmt->execute();
        $stmt->bind_result($code, $name, $continent, $region, $surfacearea, $indepyear, $population, $lifeexpectancy, $gnp, $gnpold, $localname, $governmentform, $headofstate, $capital, $code2);
        if($stmt->fetch()) {
            $tableData[] = array("Code" => $code, "Name" => $name, "Continent" => $continent, 
                "Region" => $region, "Surface Area" => $surfacearea, "Independence Year" => $indepyear, 
                "Population" => $population, "Life Expectancy" => $lifeexpectancy, "GNP" => $gnp,
                "GNP Old" => $gnpold, "Local Name" => $localname, "Government Form" => $governmentform, 
                "Head of State" => $headofstate, "Capital" => $capital, "Code 2" => $code2);        }
    }
    $editableFields = array("Local Name", "Government Form", "Independence Year", "Population");
    displayUpdate($tableData, $editableFields);
}

function showLanguageUpdate() {
    global $mylink;
    global $pkArray;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("SELECT CountryCode, Language, IsOfficial, Percentage FROM countrylanguage WHERE CountryCode = ? AND Language = ? LIMIT 1")) {
        $stmt->bind_param("ss", $pkArray['Country Code'], $pkArray['Language']);
        $stmt->execute();
        $stmt->bind_result($CountryCode, $Language, $IsOfficial, $Percentage);
        if($stmt->fetch()) {
            $tableData[] = array("Country Code" => $CountryCode, "Language" => $Language, "Is Offical?" => $IsOfficial, "Percentage" => $Percentage);
        }
    }
    $editableFields = array("Is Official?", "Percentage");
    displayUpdate($tableData, $editableFields);
    
}

switch ($pkArray["Table"]) {
    case "city":
        showCityUpdate();
        break;
    case "country":
        showCountryUpdate();
        break;
    case "countrylanguage":
        showLanguageUpdate();
        break;
    default:
        echo "ANOTHER ERROR!";
}
?>
