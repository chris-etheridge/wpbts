<?php


require_once("../../php/DBConn_Dave.php");
require_once("functions.php");

$method = $_SERVER['REQUEST_METHOD'];
if ($method != "POST") {
    echo json_encode(array("code" => "101", "message" => "Requires POST to access this API"));
    exit();
}

$userData = file_get_contents('php://input');

$jsonData = json_decode($userData, true);
if ($jsonData == null) {
    echo json_encode(array("code" => "102", "message" => "Error with JSON string, could not parse: $userData"));
    exit();
}

foreach ($jsonData as &$jsonObject) {

    $jsonObject = array_change_key_case($jsonObject, CASE_UPPER);
    foreach ($jsonObject as $key => &$item) {
        if ($item == null) {
            $jsonObject[$key] = "";
        }
        if (strcmp($key, 'PWD') != 0) {
            $jsonObject[$key] = strtoupper(strtoupper($item));
        } else {
            $jsonObject[$key] = sha1($item);
        }
    }
}

$addressID = getAddressID($jsonData[2]['LASTEMAIL']);
echo $addressID;
//doesUserExist($jsonData[2]['LASTEMAIL']);
$lastEmail = $jsonData[2]['LASTEMAIL'];

//echo $lastEmail;

updateAddress($addressID, $jsonData[1]);
updateUser($addressID, $lastEmail, $jsonData[0]);

?>