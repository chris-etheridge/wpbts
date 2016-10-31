<?php

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

//error - no id posted with request
if(!isset($_POST['eventid']))
{
    echo json_encode(array("code" => "223", "message" => "No ID specified"));
    exit();
}

$eventid = $mysqli->real_escape_string($_POST['eventid']); //filter post

$event = getEvent($mysqli, $eventid);

echo json_encode($event[0]); //return just the first element, a single event

exit();

?>
