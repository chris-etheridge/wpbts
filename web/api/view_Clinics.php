<?php

header("content-type:application/json");
require_once("../php/DBConn.php");
require_once("functions.php");

$clinicid = 0;
$clinicid = $mysqli->real_escape_string($_POST['clinicid']);

$clinics = getClinics($mysqli, $clinicid);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($clinics);

exit();