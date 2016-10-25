<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/25
 * Time: 10:49 AM
 */

require_once("php/DBConn_Dave.php");

function getAddress($addressID)
{

    echo "in address";
    global $dbConn;
    $sql = "SELECT * FROM TBL_ADDRESS WHERE ADDRESS_ID = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $addressID);
    if ($stmt->execute()) {
        //Good query
        echo "OK";
        $res = $stmt->fetchAll();
        return array(true, $res);
    } else {
        //bad query
        echo "bad";
        return array(false, "Could not access address data in database..");
    }
}


?>