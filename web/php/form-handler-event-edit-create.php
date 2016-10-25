<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");
require_once("../api/events/functions.php");

session_start();

//add variables to session for to post them back to referrer if error occured
$_SESSION['event']['title'] = $_POST['title'];
$_SESSION['event']['description'] = $_POST['description'];
$_SESSION['event']['event_date'] = $_POST['event_date'];
$_SESSION['event']['type_id'] = $_POST['type_id'];
$_SESSION['event']['event_admin'] = $_POST['event_admin'];
$_SESSION['event']['street_no'] = $_POST['street_no'];
$_SESSION['event']['street'] = $_POST['street'];
$_SESSION['event']['area'] = $_POST['area'];
$_SESSION['event']['city'] = $_POST['city'];
$_SESSION['event']['area_code'] = $_POST['area_code'];
$_SESSION['event']['creator_id'] = $_POST['creator_id'];
$_SESSION['event']['event_id'] = $_POST['event_id'];
$_SESSION['event']['address_id'] = $_POST['address_id'];

if(        !isset($_POST['creator_id']) || !isset($_POST['title'])
        || !isset($_POST['description']) || !isset($_POST['event_date']) || !isset($_POST['type_id'])
        || !isset($_POST['event_admin']) || !isset($_POST['street_no']) || !isset($_POST['street'])
        || !isset($_POST['area']) || !isset($_POST['city']) || !isset($_POST['area_code']))
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$action = (isset($_POST['eventid'])) ? "updating" : "creating"; //either create or update, used for alert message
$actionPastTense = (isset($_POST['eventid'])) ? "updated" : "created"; //either create or update, used for alert message - past tense

$eventid = $mysqli->real_escape_string($_POST['event_id']);
$creatorid = $mysqli->real_escape_string($_POST['creator_id']);
$title = $mysqli->real_escape_string($_POST['title']);
$description = $mysqli->real_escape_string($_POST['description']);
$date = $mysqli->real_escape_string($_POST['event_date']);
$typeid = $mysqli->real_escape_string($_POST['type_id']);
$adminid = $mysqli->real_escape_string($_POST['event_admin']);
$streetno = $mysqli->real_escape_string($_POST['street_no']);
$street = $mysqli->real_escape_string($_POST['street']);
$suburb = $mysqli->real_escape_string($_POST['area']);
$city = $mysqli->real_escape_string($_POST['city']);
$zip = $mysqli->real_escape_string($_POST['area_code']);
$addressid = $mysqli->real_escape_string($_POST['address_id']);

/* INSERT/ UPDATE ADDRESS*/
if(isset($_POST['address_id'])) //update address
{
    $sql = "UPDATE TBL_ADDRESS SET STREET_NO = $streetno, STREET = '$street', " 
            . "AREA = '$suburb', CITY = '$city', AREA_CODE = '$zip' " 
            . " WHERE ADDRESS_ID = $addressid";
}
else //insert new address
{
    $sql = "INSERT INTO TBL_ADDRESS (STREET_NO, STREET, AREA, CITY, AREA_CODE) VALUES($streetno, '$street', '$suburb', '$city', '$zip')";
}
$mysqli->query($sql);
$insertedAddressID = $mysqli->insert_id;

if($mysqli->error)
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error $action details!";
    $_SESSION['alert']['message'] = "Please review the address fields. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/* INSERT/ UPDATE EVENT*/
if(isset($_POST['event_id'])) //update event
{
    $sql = "UPDATE TBL_EVENT SET EVENT_DATE = STR_TO_DATE('$date', '%d-%m-%Y'), TYPE_ID = $typeid, " 
            . "DESCRIPTION = '$description', TITLE = '$title', ACTIVE = 1, "
            . "EVENT_ADMIN_ID = $adminid"
            . " WHERE EVENT_ID = $eventid;";
}
else //insert new event
{
    $sql = "INSERT INTO TBL_EVENT (EVENT_DATE, ADDRESS_ID, TYPE_ID, " 
            . "DESCRIPTION, TITLE, ACTIVE, CREATOR_ID, EVENT_ADMIN_ID) "
            . " VALUES(STR_TO_DATE('$date', '%d-%m-%Y'), $insertedAddressID, $typeid, '$description', '$title', 1, $creatorid, $adminid)";
}
$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error $action event!";
    $_SESSION['alert']['message'] = "Please review the event details. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}


$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Event $actionPastTense successfully.";
$_SESSION['event'] = null; //clear sticky form data
header('Location: ../events.php');
exit();
