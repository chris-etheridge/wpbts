<?php

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

if(!isset($_POST['eventid']) || !isset($_POST['attending']) || !isset($_POST['userid'])) //error where something crucial was not posted
{
    echo json_encode(array("code" => "443", "message" => "Not all values supplised. Required values are eventid(int), attending (int - 1 or 0), userid (int)."));
    exit();
}

//filtering post values
$eventid = (int)$mysqli->real_escape_string($_POST['eventid']);
$attending = (int)$mysqli->real_escape_string($_POST['attending']);
$userid = (int)$mysqli->real_escape_string($_POST['userid']);

if($attending !== 1 && $attending !== 0) //error where illegal option was posted. must be 1 or 0
{
    echo json_encode(array("code" => "444", "message" => "Illegal attending option specified. Accepted value is 1 (attending) or 0 (not attending)"));
    exit();
}

$response = rsvp($mysqli, $eventid, $attending, $userid);

echo json_encode($response);

exit();

?>
