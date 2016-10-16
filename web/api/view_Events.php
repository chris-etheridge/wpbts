<?php

header("content-type:application/json");
require_once("../php/DBConn.php");
require_once("functions.php");

$eventid = 0;
$eventid = $mysqli->real_escape_string($_POST['eventid']);

$events = getEvents($mysqli, $eventid);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($events);

exit();

?>
