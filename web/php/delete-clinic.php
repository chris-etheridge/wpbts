<?php

require_once("DBConn.php");
//require_once("../api/events/functions.php");

session_start();

if(!isset($_GET['clinicid']))
{
    $_SESSION['alert']['message_type'] = "alert-warning";
    $_SESSION['alert']['message_title'] = "Warning!";
    $_SESSION['alert']['message'] = "No clinic was chosen to be deleted!";
    header('Location: ../clinics.php');
    exit();
}

$clinicid = $mysqli->real_escape_string($_GET['clinicid']);

$action = "deleting";
$actionPastTense = "deleted";

$sql = "DELETE FROM TBL_CLINIC WHERE CLINIC_ID = $clinicid;";
$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error $action event!";
    $_SESSION['alert']['message'] = "Unknown error. If problem persists, contact system administrator!";
    header('Location: ../clinics.php');
    exit();
}

$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Event $actionPastTense successfully.";

header('Location: ../clinics.php');
exit();
