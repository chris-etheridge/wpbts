<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");
require_once("../api/clinics/functions.php");

session_start();

//add variables to session for to post them back to referrer if error occured
$_SESSION['clinic']['clinic_id'] = $_POST['clinic_id'];
$_SESSION['clinic']['description'] = $_POST['description'];
$_SESSION['clinic']['contact_1'] = $_POST['contact_1'];
$_SESSION['clinic']['contact_2'] = $_POST['contact_2'];

$_SESSION['clinic']['address_id'] = $_POST['address_id'];
$_SESSION['clinic']['street_no'] = $_POST['street_no'];
$_SESSION['clinic']['street'] = $_POST['street'];
$_SESSION['clinic']['area'] = $_POST['area'];
$_SESSION['clinic']['city'] = $_POST['city'];
$_SESSION['clinic']['area_code'] = $_POST['area_code'];

if(       !isset($_POST['clinic_id']) || !isset($_POST['description']) || !isset($_POST['contact_1'])
        || !isset($_POST['contact_2']) || !isset($_POST['street_no']) || !isset($_POST['street'])
        || !isset($_POST['area']) || !isset($_POST['city']) || !isset($_POST['area_code'])
        || !isset($_POST['address_id']))
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$clinicid = $mysqli->real_escape_string($_POST['clinic_id']);
$description = $mysqli->real_escape_string($_POST['description']);
$contact1 = $mysqli->real_escape_string($_POST['contact_1']);
$contact2 = $mysqli->real_escape_string($_POST['contact_2']);

$addressid = $mysqli->real_escape_string($_POST['address_id']);
$streetno = $mysqli->real_escape_string($_POST['street_no']);
$street = $mysqli->real_escape_string($_POST['street']);
$suburb = $mysqli->real_escape_string($_POST['area']);
$city = $mysqli->real_escape_string($_POST['city']);
$zip = $mysqli->real_escape_string($_POST['area_code']);

/* INSERT/ UPDATE ADDRESS*/
$sql = "UPDATE TBL_ADDRESS SET STREET_NO = $streetno, STREET = '$street', " 
        . "AREA = '$suburb', CITY = '$city', AREA_CODE = '$zip' " 
        . " WHERE ADDRESS_ID = $addressid";

$mysqli->query($sql);

if($mysqli->error)
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error updating details!";
    $_SESSION['alert']['message'] = "Please review the address fields. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/* INSERT/ UPDATE CLINIC*/

$sql = "UPDATE TBL_CLINIC SET DESCRIPTION = '$description', "
        . "CONTACT_1 = '$contact1', "
        . "CONTACT_2 = '$contact2'"
        . " WHERE CLINIC_ID = $clinicid;";

$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error updating clinic!";
    $_SESSION['alert']['message'] = "Please review the clinic details. If problem persists, contact system administrator!" ;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}


$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Clinic updated successfully.";
$_SESSION['event'] = null; //clear sticky form data
header('Location: ../clinics.php');
exit();
