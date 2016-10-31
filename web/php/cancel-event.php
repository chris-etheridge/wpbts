<?php

require_once("DBConn.php");
//require_once("../api/events/functions.php");

session_start();

if(!isset($_GET['eventid']) || !isset($_GET['cancel']))//verify everything crucial was posted
{
    $_SESSION['alert']['message_type'] = "alert-warning";
    $_SESSION['alert']['message_title'] = "Warning!";
    $_SESSION['alert']['message'] = "No event was chosen to be cancelled!";
    header('Location: ../events.php');
    exit();
}

//setting local variables to filtered post values for sql statements
$eventid = $mysqli->real_escape_string($_GET['eventid']);
$status = $mysqli->real_escape_string($_GET['cancel']);

//local variables used as part of the message that will be returned to the user based on a toggle
$action = ((int)$status === 0) ? "canceling" : "uncanceling";
$actionPastTense = ((int)$status === 0) ? "canceled" : "uncanceled";

$sql = "UPDATE TBL_EVENT SET ACTIVE = $status WHERE EVENT_ID = $eventid;";
$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    //send through error message
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error $action event!";
    $_SESSION['alert']['message'] = "Unknown error. If problem persists, contact system administrator!";
    header('Location: ../events.php');
    exit();
}

//redirect back to previous page with success message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Event $actionPastTense successfully.";

header('Location: ../events.php');
exit();
