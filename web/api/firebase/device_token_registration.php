<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/28
 * Time: 9:41 AM
 *
 * Gets the device token from the devics and writes this to the database.
 *
 */

require_once("../../php/DBConn_Dave.php");
//require_once("functions.php");
global $dbConn;


$receivedData = file_get_contents('php://input');

$jsonString = json_decode($receivedData, true);
if ($jsonString == null) {
    echo "Error with JSON string, could not parse: $userData";
    die();
}


$userEmail = $jsonString['EMAIL'];
$userToken = $jsonString['TOKEN'];

$sql = "INSERT INTO TBL_DEVICES (DEVICE_EMAIL, DEVICE_TOKEN) VALUES (?,?)";
$stmt = $dbConn->prepare($sql);
$stmt->bindParam(1, $userEmail);
$stmt->bindParam(2, $userToken);

if ($stmt->execute()) {
    echo "112 - Success, device token registered";
} else {
    echo "111 - Error: " . print_r($stmt->errorInfo());
}
