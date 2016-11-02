<?php
//author = Kyle Burton

$GLOBALS['FCMServerKey'] = "AIzaSyAGqEvspvB03dZSawIjfp2xj_2lF1VRtmw";
$GLOBALS['FCMurl'] = 'https://fcm.googleapis.com/fcm/send';

$ErrorMsgs = array();
$mysqli = new mysqli("localhost", "root", "", "wpbts");
if ($mysqli->connect_errno)
{
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
