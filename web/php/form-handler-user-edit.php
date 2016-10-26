<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/25
 * Time: 4:54 PM
 */

require_once('../php/DBConn_Dave.php');
include_once("users_functions.php");
include_once("address_functions.php");

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
$_SESSION['USER']['PWD'] = sha1($_POST['PASSWORD']);
$_SESSION['USER']['TITLE'] = $_POST['TITLE'];
$_SESSION['USER']['LAST_EMAIL'] = $_POST['LAST_EMAIL'];


global $dbConn;
$sql = "UPDATE TBL_USER SET
        FIRST_NAME = ?,
        LAST_NAME = ?,
        NATIONAL_ID = ?,
        EMAIL = ?,
        PHONE = ?,
        BLOOD_TYPE = ?,
        DATE_OF_BIRTH = ?,
        TITLE = ?,
        GENDER = ?,
        LANGUAGE_PREF = ?,
        PASSPORT_NUM = ?,
        PWD = ?
        WHERE EMAIL = ?
";
$stmt = $dbConn->prepare($sql);
$stmt->bindParam(1, $_SESSION['USER']['FIRST_NAME']);
$stmt->bindParam(2, $_SESSION['USER']['LAST_NAME']);
$stmt->bindParam(3, $_SESSION['USER']['NATIONAL_ID']);
$stmt->bindParam(4, $_SESSION['USER']['EMAIL']);
$stmt->bindParam(5, $_SESSION['USER']['PHONE']);
$stmt->bindParam(6, $_SESSION['USER']['BLOOD_TYPE']);
$stmt->bindParam(7, $_SESSION['USER']['DATE_OF_BIRTH']);
$stmt->bindParam(8, $_SESSION['USER']['TITLE']);
$stmt->bindParam(9, $_SESSION['USER']['GENDER']);
$stmt->bindParam(10, $_SESSION['USER']['LANGUAGE_PREF']);
$stmt->bindParam(11, $_SESSION['USER']['PASSPORT_NO']);
$stmt->bindParam(12, $_SESSION['USER']['PWD']);
$stmt->bindParam(13, $_SESSION['USER']['LAST_EMAIL']);

if ($stmt->execute()) {
    echo "UPDATES";
} else {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Update failed.";
    $_SESSION['alert']['message'] = "Please check the server logs.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$_SESSION['alert'] = null;
header('Location: ../users.php');

//
//UPDATE table_name SET field1 = new-value1, field2 = new-value2
//    [WHERE Clause]


?>
<!---->
