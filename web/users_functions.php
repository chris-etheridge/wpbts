<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/24
 * Time: 1:04 PM
 *
 * Supplimentary functons to the users management page.
 *
 *
 */


include_once("php/DBConn_Dave.php");

function getUser($userID)
{
    global $dbConn;
    $sql = "SELECT * FROM TBL_USER WHERE USER_ID = $userID";
    $stmt = $dbConn->prepare($sql);
    if ($stmt->execute()) {
        //Good Query return data
        $res = $stmt->fetchAll();
        return array(true, $res);
    } else {
        //Bad Query Return data
        return array(false, "ERROR: " . print_r($stmt->errorInfo()));
    }
}

function getAllUsers()
{
    //Returns bool and data
    //If false, returns the error info
    global $dbConn;
    $sql = "SELECT * FROM TBL_USER";
    $stmt = $dbConn->prepare($sql);

    if ($stmt->execute()) {
        //We are good
        $res = $stmt->fetchAll();
        return array(true, $res);
    } else {
        $res = array(false, "Error: " . print_r($stmt->errorInfo()));
    }
}


?>