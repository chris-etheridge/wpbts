<?php

require_once("../../php/DBConn_Dave.php");
require_once("functions.php");

$postMethod = $_SERVER['REQUEST_METHOD'];

if ($postMethod != 'POST') {
    echo '117 - Login request must be post';
    die();
}

$receivedData = file_get_contents('php://input');
$jsonData = json_decode($receivedData, true);
if ($jsonData == null) {
    echo json_encode(array("code" => "155", "message" => "Incorrect format provided."));
}

$jsonData = array_change_key_case($jsonData, CASE_UPPER);
foreach ($jsonData as $key => &$values) {
    if (strcmp($key, 'PWD') != 0) {
        $jsonData[$key] = strtoupper($jsonData[$key]);
    }
}

$email = $jsonData['EMAIL'];

$password = sha1($jsonData['PWD']);


//WE EXTRACT BOTH THE EMAIL ADDRESS ALONG WTH THE USER ID INTO THIS VARIABLE
$isIUserExist = doesEmailAddressExist($email);

if ($isIUserExist == false) {
    echo json_encode(array("code" => "111", "message" => "User does not exists."));
    die();
}


//WE PULL THE USER PASSWORD AND USER ID
$savedPassword = getHashedPassword($email);
$extrPassword = $savedPassword[0]['PWD'];


if (strcmp($password, $extrPassword) == 0) {
    echo json_encode(array("code" => "182", "message" => "User logged in successfully.", "savedPW" => $savedPassword[0][PWD], "userID" => $isIUserExist['USER_ID']));
} else {
    echo json_encode(array("code" => "181", "message" => "Incorrect password."));
}

?>
