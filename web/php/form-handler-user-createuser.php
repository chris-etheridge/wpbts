<?php

require_once('../php/DBConn_Dave.php');
include_once("../users_functions.php");
include_once("../address_functions.php");

session_start();

//SETUP SESSION VARIABLES:
$_SESSION['USER']['USER_ID'] = $_POST['USER_ID'];
$_SESSION['USER']['FIRST_NAME'] = $_POST['FIRST_NAME'];
$_SESSION['USER']['LAST_NAME'] = $_POST['LAST_NAME'];
$_SESSION['USER']['NATIONAL_ID'] = $_POST['NATIONAL_ID'];
$_SESSION['USER']['EMAIL'] = $_POST['EMAIL'];
$_SESSION['USER']['PHONE'] = $_POST['PHONE'];
$_SESSION['USER']['STREET_NO'] = $_POST['STREET_NO'];
$_SESSION['USER']['STREET'] = $_POST['STREET'];
$_SESSION['USER']['OFFICE'] = $_POST['OFFICE'];
$_SESSION['USER']['BUILDING_NUMBER'] = $_POST['BUILDING_NUMBER'];
$_SESSION['USER']['DATE_OF_BIRTH'] = $_POST['DATE_OF_BIRTH'];
$_SESSION['USER']['BLOOD_TYPE'] = $_POST['BLOOD_TYPE'];
$_SESSION['USER']['GENDER'] = $_POST['GENDER'];
$_SESSION['USER']['LANGUAGE_PREF'] = $_POST['LANGUAGE_PREF'];
$_SESSION['USER']['PASSPORT_NO'] = $_POST['PASSPORT_NO'];
$_SESSION['USER']['AREA'] = $_POST['AREA'];
$_SESSION['USER']['AREA_CODE'] = $_POST['AREA_CODE'];
$_SESSION['USER']['CITY'] = $_POST['CITY'];
$_SESSION['USER']['PASSWORD'] = $_POST['PASSWORD'];
$_SESSION['USER']['TITLE'] = $_POST['TITLE'];

//we need to validate that the user is not existing and
//if the user exists, return to the page with the session variables.
$isExistsUser = doesUserExist($_SESSION['USER']['EMAIL']);
if ($isExistsUser) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Email exists!";
    $_SESSION['alert']['message'] = "The user email already exists, this use alerady exists";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//NEED TO UPDATE WITH CORRECTIONS.
//if the user does not exist, we need to create the address
//get the ID of the address

$_SESSION['USER']['BUILDING_NUMBER'];
$_POST['BUILDING_NUMBER'];

//$addressData = array(
//    'STREET_NO' => $_SESSION['USER']['STREET_NO'],
//    'CITY' => $_SESSION['USER']['CITY'],
//    'OFFICE' => $_SESSION['USER']['OFFICE'],
//    'STREET' => $_SESSION['USER']['STREET'],
//    'AREA' => $_SESSION['USER']['AREA'],
//    'AREA_CODE' => $_SESSION['USER']['AREA_CODE'],
//    'BUILDING_NUMBER' => $_SESSION['USER']['BUILDING_NUMBER'],
//);
//
//$addressResult = createAddress($addressData);
//
//if ($addressResult == false) {
//    $_SESSION['alert']['message_type'] = "alert-danger";
//    $_SESSION['alert']['message_title'] = "Address write error!";
//    $_SESSION['alert']['message'] = "The address data was incorrect, ensure correct data types . ";
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
//    exit();
//}


?>