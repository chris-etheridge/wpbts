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

$receivedData = file_get_contents('php://input');

$jsonString = json_decode($receivedData, true);
if ($jsonString == null) {
    echo "Error with JSON string, could not parse: $userData";
    die();
}


$userEmail = $jsonString['EMAIL'];
$userToken = $jsonString['TOKEN'];

$sql = "";
