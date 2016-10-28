<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/28
 * Time: 10:52 AM
 */

require_once("alerts_functions.php");
session_start();


$alertData = array(
    "TYPE_ID" => $_POST["TYPE_ID"],
    "TITLE" => $_POST["TITLE"],
    "BODY" => $_POST["BODY"],
    "DESCRIPTION" => $_POST["DESCRIPTION"]
);

$res = createAlert($alertData);
if ($res == false) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error writing alert to DB. ";
    $_SESSION['alert']['message'] = "Please check the database logs.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    $_SESSION['alert']['message_type'] = "alert-success";
    $_SESSION['alert']['message_title'] = "Alert created";
    $_SESSION['alert']['message'] = ". Using the alert, send it to relevant users.";
    header('Location: ../alerts.php');
    exit();
}