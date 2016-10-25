<?php

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

if(!isset($_POST['eventid']))
{
    echo json_encode(array("code" => "223", "message" => "No ID specified"));
    exit();
}
$eventid = $mysqli->real_escape_string($_POST['eventid']);

$_SESSION['event'] = getEvent($mysqli, $eventid);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($_SESSION['event'][0]);

exit();

?>
