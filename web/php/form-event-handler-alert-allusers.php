<?php

require_once("../php/DBConn.php");
require_once("alerts_functions.php");

session_start();

echo "Hello";


$allDevices = getAllDevices();


var_dump($allDevices);

//if ($allDevices == false) {
//    $_SESSION['alert']['message_type'] = "alert-danger";
//    $_SESSION['alert']['message_title'] = "DB Read error getting devices.  ";
//    $_SESSION['alert']['message'] = "Please check db logs.";
//    header('Location: ../alerts.php');
//    exit();
//}
//
//var_dump($allDevices);
//die();
//
//
//
//
//


