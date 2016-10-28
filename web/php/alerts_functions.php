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

function createAlert($alertData)
{

    global $dbConn;
    $sql = "INSERT INTO TBL_ALERT(TYPE_ID, TITLE, BODY, DESCRIPTION) VALUES(?,?,?,?)";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $alertData['TYPE_ID']);
    $stmt->bindParam(2, $alertData['TITLE']);
    $stmt->bindParam(3, $alertData['BODY']);
    $stmt->bindParam(4, $alertData['DESCRIPTION']);

    if ($stmt->execute()) {
        return true;
    } else {
        print_r($stmt->errorInfo());
        die();

    }
}