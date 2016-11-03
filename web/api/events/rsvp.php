<?php
//author = Kyle Burton

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

$receivedData = file_get_contents('php://input');
$jsonData = json_decode($receivedData, true);

if(!isset($jsonData['eventid']) || !isset($jsonData['attending']) || !isset($jsonData['userid'])) //error where something crucial was not posted
{    
    echo json_encode(array("code" => "443", "message" => "Not all values supplised. Required values are eventid(int), attending (int - 1 or 0), userid (int)."));
    exit();
}

//filtering post values
$eventid = (int)$mysqli->real_escape_string($jsonData['eventid']);
$attending = (int)$mysqli->real_escape_string($jsonData['attending']);
$userid = (int)$mysqli->real_escape_string($jsonData['userid']);

if($attending !== 1 && $attending !== 0) //error where illegal option was posted. must be 1 or 0
{
    echo json_encode(array("code" => "444", "message" => "Illegal attending option specified. Accepted value is 1 (attending) or 0 (not attending)"));
    exit();
}

$response = rsvp($mysqli, $eventid, $attending, $userid);

echo json_encode($response);

exit();

?>
