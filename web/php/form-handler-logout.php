<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/26
 * Time: 8:12 PM
 */

session_start();
//remove auth var
$_SESSION['AUTH_USER_ID'] = null;

//setup notification
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "Logout Success";
$_SESSION['alert']['message'] = " To access the system, please log in.";
header('Location: ../login.php');
exit();
