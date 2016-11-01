<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/28
 * Time: 10:33 AM
 */

require_once('DBConn_Dave.php');

function getAllALerts()
{
    global $dbConn;
    $sql = "SELECT * FROM TBL_ALERT";
    $stmt = $dbConn->prepare($sql);
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

}

function getAlert($alertid)
{
    global $dbConn;
    $sql = "SELECT * FROM TBL_ALERT WHERE ALERT_ID = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $alertid);
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

}

function createAlert($alertData)
{

    global $dbConn;
    $sql = "INSERT INTO TBL_ALERT(TITLE, BODY, DESCRIPTION) VALUES(?,?,?)";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $alertData['TITLE']);
    $stmt->bindParam(2, $alertData['BODY']);
    $stmt->bindParam(3, $alertData['DESCRIPTION']);

    if ($stmt->execute()) {
        return true;
    } else {
        print_r($stmt->errorInfo());
        die();

    }
}

function getAllDevices()
{
    global $dbConn;
    $sql = "SELECT * FROM TBL_DEVICES";
    $stmt = $dbConn->prepare($sql);
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

}