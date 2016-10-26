<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/26
 * Time: 12:23 PM
 */

session_start();
include("../address_functions.php");
include("../users_functions.php");

$userIDToRemove = $_GET['userID'];
$addressIDToRemove = $_GET['addressID'];


//lets remove the user and finally, lets remove the address.
$userDelResult = deleteUser($userIDToRemove);
//if ($userDelResult == false) {
//    $_SESSION['alert']['message_type'] = "alert-danger";
//    $_SESSION['alert']['message_title'] = "Unable to remove user record, check server logs";
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
//    exit();
//}
////
//
//$addrDeleteionResult = removeAddress($addressIDToRemove);
//if ($addrDeleteionResult == false) {
//    $_SESSION['alert']['message_type'] = "alert-danger";
//    $_SESSION['alert']['message_title'] = "Unable to remove address record, check server logs.";
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
//    exit();
//}
//
//
//
//
