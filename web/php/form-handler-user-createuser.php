<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/26
 * Time: 9:54 AM
 *
 * To create a user
 *
 */

require_once('../php/DBConn_Dave.php');
include_once("../users_functions.php");
include_once("../address_functions.php");

session_start();

//SETUP SESSION VARIABLES:
$_SESSION['USER_ID'] = $_POST['USER_ID'];
$_SESSION['FIRST_NAME'] = $_POST['FIRST_NAME'];
$_SESSION['LAST_NAME'] = $_POST['LAST_NAME'];
$_SESSION['NATIONAL_ID'] = $_POST['NATIONAL_ID'];
$_SESSION['EMAIL'] = $_POST['EMAIL'];
$_SESSION['PHONE'] = $_POST['PHONE'];
$_SESSION['STREET_NO'] = $_POST['STREET_NO'];
$_SESSION['STREET'] = $_POST['STREET'];
$_SESSION['OFFICE'] = $_POST['OFFICE'];
$_SESSION['BUILDING_NUMBER'] = $_POST['BUILDING_NUMBER'];
$_SESSION['DATE_OF_BIRTH'] = $_POST['DATE_OF_BIRTH'];
$_SESSION['BLOOD_TYPE'] = $_POST['BLOOD_TYPE'];
$_SESSION['GENDER'] = $_POST['GENDER'];
$_SESSION['LANGUAGE_PREF'] = $_POST['LANGUAGE_PREF'];
$_SESSION['PASSPORT_NO'] = $_POST['PASSPORT_NO'];
$_SESSION['AREA'] = $_POST['AREA'];
$_SESSION['AREA_CODE'] = $_POST['AREA_CODE'];
$_SESSION['CITY'] = $_POST['CITY'];
$_SESSION['PASSWORD'] = $_POST['PASSWORD'];
$_SESSION['TITLE'] = $_POST['TITLE'];


$userExists = doesUserExist($_SESSION['EMAIL']);
if ($userExists) {
    $_SESSION['ALERT'] = "User already exists";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

$addressData = array(
    "STREET_NO" => $_SESSION['STREET_NO'],
    "STREET" => $_SESSION['STREET'],
    "OFFICE" => $_SESSION['OFFICE'],
    "BUILDING_NUMBER" => $_SESSION['BUILDING_NUMBER'],
    "AREA" => $_SESSION['AREA'],
    "AREA_CODE" => $_SESSION['AREA_CODE'],
    "CITY" => $_SESSION['CITY']
);
$addressID = createAddress($addressData);
if ($addressID == false) {
    $_SESSION['ALERT'] = "Error writing to DB: Check field types";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
echo $addressID;

echo $_SESSION['DATE_OF_BIRTH'];

$userData = array(
    "USER_ID" => $_SESSION['USER_ID'],
    "FIRST_NAME" => $_SESSION['FIRST_NAME'],
    "LAST_NAME" => $_SESSION['LAST_NAME'],
    "NATIONAL_ID" => $_SESSION['NATIONAL_ID'],
    "EMAIL" => $_SESSION['EMAIL'],
    "PHONE" => $_SESSION['PHONE'],
    "DATE_OF_BIRTH" => $_SESSION['DATE_OF_BIRTH'],
    "BLOOD_TYPE" => $_SESSION['BLOOD_TYPE'],
    "GENDER" => $_SESSION['GENDER'],
    "LANGUAGE_PREF" => $_SESSION['LANGUAGE_PREF'],
    "PASSPORT_NUM" => $_SESSION['PASSPORT_NO'],
    "PWD" => $_SESSION['PASSWORD'],
    "TITLE" => $_SESSION['TITLE']

);
$result = createUser($userData, $addressID);
if ($result == false) {
    $_SESSION['ALERT'] = "Error creating user, check field types...";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
session_destroy();
header("Location: ../users.php");





