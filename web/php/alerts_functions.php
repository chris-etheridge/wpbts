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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

}