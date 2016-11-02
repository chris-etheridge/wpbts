<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/28
 * Time: 10:52 AM
 */

require_once("notification_functions.php");
session_start();


$notificationData = array(
    "TITLE" => $_POST["TITLE"],
    "BODY" => $_POST["BODY"],
    "DESCRIPTION" => $_POST["DESCRIPTION"]
);

$res = createNotification($notificationData);
if ($res == false) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error writing notification to DB. ";
    $_SESSION['alert']['message'] = "Please check the database logs.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    $_SESSION['alert']['message_type'] = "alert-success";
    $_SESSION['alert']['message_title'] = "Notification created";
    $_SESSION['alert']['message'] = ". Notification the alert, send it to relevant users.";
    header('Location: ../notifications.php');
    exit();
}