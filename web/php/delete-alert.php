<?php

require_once("DBConn.php");
//require_once("../api/events/functions.php");

session_start();

if(!isset($_GET['alertid']))//verify everything crucial was posted
{
    $_SESSION['alert']['message_type'] = "alert-warning";
    $_SESSION['alert']['message_title'] = "Warning!";
    $_SESSION['alert']['message'] = "No alert was chosen to be deleted!";
    header('Location: ../alerts.php');
    exit();
}

//setting local variables to filtered post values for sql statements
$alertid = $mysqli->real_escape_string($_GET['alertid']);

$sql = "DELETE FROM TBL_ALERT WHERE ALERT_ID = $alertid;";
$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    //send through error message
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error deleting alert!";
    $_SESSION['alert']['message'] = "Unknown error. If problem persists, contact system administrator!";
    header('Location: ../alerts.php');
    exit();
}

//redirect back to previous page with success message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Alert deleted successfully.";

header('Location: ../alerts.php');
exit();
