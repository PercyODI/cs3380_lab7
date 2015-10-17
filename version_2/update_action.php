<?php
$pkArray = unserialize($_GET['pk']);

function showCityUpdate() {
    global $mylink;
    global $pkArray;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("UPDATE city SET District = ?, Population = ? WHERE ID = ? LIMIT 1")) {
        $stmt->bind_param("sss", $_GET['District'], $_GET['Population'], $pkArray['ID']);
        $stmt->execute();
    }
}

function showCountryUpdate() {
    global $mylink;
    global $pkArray;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("UPDATE country SET IndepYear = ?, Population = ?, LocalName = ?, GovernmentForm = ?,  WHERE code = ? LIMIT 1")) {
        $stmt->bind_param("sssss", $_GET['IndepYear'], $_GET['Population'], $_GET['LocalName'], $_GET['GovernmentForm'], $pkArray['Code']);
        $stmt->execute();
    }
}

function showLanguageUpdate() {
    global $mylink;
    global $pkArray;
    $stmt = null;
    $tableData = array();
    
    if($stmt = $mylink->prepare("UPDATE countrylanguage SET IsOfficial = ?, Percentage = ? WHERE CountryCode = ? AND Language = ? LIMIT 1")) {
        $stmt->bind_param("ssss", $_GET['IsOfficial'], $_GET['Percentage'], $pkArray['Country Code'], $pkArray['Language']);
        $stmt->execute();
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
