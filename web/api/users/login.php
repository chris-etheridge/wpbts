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
    echo "155 - Paramaters must be in json string format";
}

$jsonData = array_change_key_case($jsonData, CASE_UPPER);
foreach ($jsonData as $key => &$values) {
    $res = strcmp($key, "PWD");
    if ($res != 'PWD') {
        $jsonData[$key] = strtoupper($jsonData[$key]);
    }
}

//var_dump($jsonData);
$email = $jsonData['EMAIL'];
$password = sha1($jsonData['PWD']);


$isIUserExist = doesEmailAddressExist($email);
if ($isIUserExist == false) {
    echo "111 - User does not exist";
    die();
}

$savedPassword = getHashedPassword($email);
var_dump($savedPassword);

if (strcmp($password, $savedPassword['PWD']) == 0) {
    echo "112 - Login Accepted.";
} else {
    echo "181 - Autentication Failed.";
}

?>