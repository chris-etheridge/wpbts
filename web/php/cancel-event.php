<?php

require_once("DBConn.php");
//require_once("../api/events/functions.php");

session_start();

if(!isset($_GET['eventid']) || !isset($_GET['cancel']))
{
    $_SESSION['alert']['message_type'] = "alert-warning";
    $_SESSION['alert']['message_title'] = "Warning!";
    $_SESSION['alert']['message'] = "No event was chosen to be cancelled!";
    header('Location: ../events.php');
    exit();
}

$eventid = $mysqli->real_escape_string($_GET['eventid']);
$status = $mysqli->real_escape_string($_GET['cancel']);

$action = ((int)$status === 0) ? "canceling" : "uncanceling";
$actionPastTense = ((int)$status === 0) ? "canceled" : "uncanceled";

$sql = "UPDATE TBL_EVENT SET ACTIVE = $status WHERE EVENT_ID = $eventid;";
$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error $action event!";
    $_SESSION['alert']['message'] = "Unknown error. If problem persists, contact system administrator!";
    header('Location: ../events.php');
    exit();
}

$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Event $actionPastTense successfully.";

header('Location: ../events.php');
exit();
