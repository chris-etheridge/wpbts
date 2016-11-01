<?php

header("content-type:application/json");

/**
 * Gets the device token from the devics and writes this to the database.
 *
 */

require_once("DBConn.php");

//error - no id posted with request
if(!isset($_POST['userid']) && !isset($_POST['devicetoken']))
{
    echo json_encode(array("code" => "555", "message" => "No ID and/or device token specified"));
    exit();
}

$userid = $mysqli->real_escape_string($_POST['userid']);
$devicetoken = $mysqli->real_escape_string($_POST['devicetoken']);

$sql = "UDPATE TBL_USER SET DEVICE_TOKEN = '$devicetoken' WHERE USER_ID = $userid";

$mysqli->query($sql);

if($mysqli->error)
{
    echo json_encode(array("code" => "556", "message" => "Error updating device token. Try again"));
    exit();
}

echo json_encode(array("code" => "550", "message" => "Successfully updated device token"));

exit();