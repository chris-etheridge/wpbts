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

//Remove user:
$userRemoval = deleteUser($_GET['userID']);
if ($userRemoval == false) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Deletion Error:";
    $_SESSION['alert']['message'] = "Please check server logs.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$addressRemoval = removeAddress($_GET['addressID']);
if ($userRemoval == false) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Deletion Error:";
    $_SESSION['alert']['message'] = "Please check server logs.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$_SESSION['ALERT'] = null;
header('Location: ..\users.php');


?>