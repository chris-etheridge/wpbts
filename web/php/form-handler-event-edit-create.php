<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");
require_once("../api/events/functions.php");

session_start();

if(        !isset($_POST['creatorid']) || !isset($_POST['title'])
        || !isset($_POST['description']) || !isset($_POST['date']) || !isset($_POST['typeid'])
        || !isset($_POST['eventadminid']) || !isset($_POST['streetno']) || !isset($_POST['street'])
        || !isset($_POST['suburb']) || !isset($_POST['city']) || !isset($_POST['zip']))
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$action = (isset($_POST['eventid'])) ? "updating" : "creating"; //either create or update, used for alert message
$actionPastTest = (isset($_POST['eventid'])) ? "updated" : "created"; //either create or update, used for alert message - past tense

$eventid = $mysqli->real_escape_string($_POST['eventid']);
$creatorid = $mysqli->real_escape_string($_POST['creatorid']);
$title = $mysqli->real_escape_string($_POST['title']);
$description = $mysqli->real_escape_string($_POST['description']);
$date = $mysqli->real_escape_string($_POST['date']);
$typeid = $mysqli->real_escape_string($_POST['typeid']);
$adminid = $mysqli->real_escape_string($_POST['eventadminid']);
$streetno = $mysqli->real_escape_string($_POST['streetno']);
$street = $mysqli->real_escape_string($_POST['street']);
$suburb = $mysqli->real_escape_string($_POST['suburb']);
$city = $mysqli->real_escape_string($_POST['city']);
$zip = $mysqli->real_escape_string($_POST['zip']);
$addressid = $mysqli->real_escape_string($_POST['address_id']);

/* INSERT/ UPDATE ADDRESS*/
if(isset($addressid)) //update address
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

if($mysqli->error)
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error $action details!";
    $_SESSION['alert']['message'] = "Please review the address fields. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/* INSERT/ UPDATE EVENT*/
if(isset($eventid)) //update event
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
            . " VALUES(STR_TO_DATE('$date', '%d-%m-%Y'), '', $typeid, '$description', '$title', 1, $creatorid, $adminid)";
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
$_SESSION['alert']['message_title'] = "Event $actionPastTest successfully";
$_SESSION['alert']['message'] = "Event $actionPastTest successfully";

header('Location: ../events.php');
exit();
