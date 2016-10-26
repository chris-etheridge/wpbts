<?php

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

if(!isset($_POST['eventid']) || !isset($_POST['attending']) || !isset($_POST['userid']))
{
    echo json_encode(array("code" => "443", "message" => "Not all values supplised. Required values are eventid(int), attending (int - 1 or 0), userid (int)."));
    exit();
}
$eventid = (int)$mysqli->real_escape_string($_POST['eventid']);
$attending = (int)$mysqli->real_escape_string($_POST['attending']);
$userid = (int)$mysqli->real_escape_string($_POST['userid']);

if($attending !== 1 && $attending !== 0)
{
    echo json_encode(array("code" => "444", "message" => "Illegal attending option specified. Accepted value is 1 (attending) or 0 (not attending)"));
    exit();
}

$response = rsvp($mysqli, $eventid, $attending, $userid);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.

echo json_encode($response);

exit();

?>
