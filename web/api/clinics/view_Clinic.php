<?php

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

//error - no id posted with request
if(!isset($_POST['clinicid'])) 
{
    echo json_encode(array("code" => "333", "message" => "No ID specified"));
    exit();
}

$clinicid = $mysqli->real_escape_string($_POST['clinicid']); //filter post

$clinic = getClinic($mysqli, $clinicid);

echo json_encode($clinic[0]); //return just the first element, a single clinic

exit();