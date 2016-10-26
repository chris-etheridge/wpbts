<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/26
 * Time: 7:24 PM
 */

require_once("../php/DBConn_Dave.php");
session_start();

$userEmail = $_POST['USERNAME'];
$password = sha1($_POST['PASSWORD']);
//echo "ORIG PASS:" . $password;

global $dbConn;
$sql = "SELECT USER_ID, PWD FROM TBL_USER WHERE EMAIL = ?";
$stmt = $dbConn->prepare($sql);
$stmt->bindParam(1, $userEmail);

if ($stmt->execute() == false) {
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Login failed, DB error.";
    $_SESSION['alert']['message'] = "Please check the server logs.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    //INVALID EMAIL TEST
    if ($res == null) {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Invalid Username";
        $_SESSION['alert']['message'] = "The email address specified does not exist.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    //WRONG PASSWORD TEST
    if ((strcmp($password, $res['PWD']) == 0) == false) {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Login failed";
        $_SESSION['alert']['message'] = "The password was incorrect.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {

        //LOGIN SUCCESS
        $_SESSION['AUTH_USER_ID'] = $res['USER_ID'];

        if (isset($_POST['COOKKIE'])) {
            $cookie_name = 'EMAIL_COOKIE';
            setcookie($cookie_name, $userEmail, time() + (86400 * 365), "/"); // 86400 = 1 day
        }

        header('Location: ../index.php');


    }

}


?>
