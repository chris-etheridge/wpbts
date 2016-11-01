<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");

session_start();

//add variables to session for to post them back to referrer if error occured
$_SESSION['alert']['ALERT_ID'] = $_POST['ALERT_ID'];
$_SESSION['alert']['TITLE'] = $_POST['TITLE'];
$_SESSION['alert']['DESCRIPTION'] = $_POST['DESCRIPTION'];
$_SESSION['alert']['BODY'] = $_POST['BODY'];

if(       !isset($_POST['ALERT_ID']) || !isset($_POST['TITLE']) || !isset($_POST['DESCRIPTION'])
        || !isset($_POST['BODY']))
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//setting local variables to filtered post values for sql statements
$alertid = $mysqli->real_escape_string($_POST['ALERT_ID']);
$description = $mysqli->real_escape_string($_POST['DESCRIPTION']);
$body = $mysqli->real_escape_string($_POST['BODY']);
$title = $mysqli->real_escape_string($_POST['TITLE']);


/* INSERT/ UPDATE CLINIC*/

$sql = "UPDATE TBL_ALERT SET DESCRIPTION = '$description', "
        . "BODY = '$body', "
        . "TITLE = '$title'"
        . " WHERE ALERT_ID = $alertid;";

$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error updating alert!";
    $_SESSION['alert']['message'] = "Please review the clinic details. If problem persists, contact system administrator!" ;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}


//redirect back to previous page with success message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Alert updated successfully.";
$_SESSION['event'] = null; //clear sticky form data
header('Location: ../alerts.php');
exit();
