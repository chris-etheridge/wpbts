<?php
//author = Kyle Burton

$FCMServerKey = "AIzaSyAGqEvspvB03dZSawIjfp2xj_2lF1VRtmw";

$ErrorMsgs = array();
$mysqli = new mysqli("localhost", "root", "", "wpbts");
if ($mysqli->connect_errno)
{
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
