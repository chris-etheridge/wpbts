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

function isAddressExist($userAddressFromWeb)
{

}

function createAddress($address)
{
    global $dbConn;
    $sql = "INSERT INTO TBL_ADDRESS(ADDRESS_ID,
        STREET_NO, 
        CITY,   
        OFFICE, 
        STREET, 
        AREA, 
        AREA_CODE, 
        BUILDING_NUMBER) 
          VALUES(?,?,?,?,?,?,?,?)";

    $lastID = getLastID("TBL_ADDRESS", "ADDRESS_ID");
    $lastID = (int)$lastID + 1;

    //echo $lastID;

    //var_dump($address);

    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $lastID);
    $stmt->bindParam(2, $address['STREET_NO']);
    $stmt->bindParam(3, $address['CITY']);
    $stmt->bindParam(4, $address['OFFICE']);
    $stmt->bindParam(5, $address['STREET']);
    $stmt->bindParam(6, $address['AREA']);
    $stmt->bindParam(7, $address['AREA_CODE']);
    $stmt->bindParam(8, $address["BUILDING_NUMBER"]);

    if ($stmt->execute() == false) {
        //print_r($stmt->errorInfo());
        return false;
    }
    return $lastID;
}

function getLastID($tableName, $column)
{

    global $dbConn;
    $sql = "select $column from $tableName ORDER BY $column DESC LIMIT 1";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res[$column];

}

?>