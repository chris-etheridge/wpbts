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

function doesUserExist($userEmail)
{
    echo $userEmail;
    global $dbConn;
    $sql = "SELECT * FROM TBL_USER WHERE EMAIL = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $userEmail);
    if ($stmt->execute()) {
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res != null) {
            var_dump($res);
            return true;
        } else {
            return false;
        }
    } else {
        echo "Error";
    }
}

function getLastIDForTable($tableName = 'TBL_USER', $column = 'USER_ID')
{
    global $dbConn;
    $sql = "select $column from $tableName ORDER BY $column DESC LIMIT 1";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res[$column];

}


function createUser($userData)
{
    global $dbConn;

    $sql = "INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL,
        PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE,
        GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD)
      VALUES(?,?,?,?,?,
            ?,?,?,?,?,
            ?,?,?,?)";

    $stmt = $dbConn->prepare($sql);

    $stmt->bindParam(1, $userData['USER_ID']);
    $stmt->bindParam(2, $userData['FIRST_NAME']);
    $stmt->bindParam(3, $userData['LAST_NAME']);
    $stmt->bindParam(4, $userData['NATIONAL_ID']);
    $stmt->bindParam(5, $userData['EMAIL']);
    $stmt->bindParam(6, $userData['PHONE']);
    $stmt->bindParam(7, $userData['BLOOD_TYPE']);
    $stmt->bindParam(8, $userData['ADDRESS_ID']);
    $stmt->bindParam(9, $userData['DATE_OF_BIRTH']);
    $stmt->bindParam(10, $userData['TITLE']);
    $stmt->bindParam(11, $userData['GENDER']);
    $stmt->bindParam(12, $userData['LANGUAGE_PREF']);
    $stmt->bindParam(13, $userData['PASSPORT_NUM']);
    $stmt->bindParam(14, $userData['PWD']);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function deleteUser($userID)
{

    echo $userID;
//    global $dbConn;
//    $sql = "DELETE FROM TBL_USER WHERE USER_ID = ?";
//    $stmt = $dbConn->prepare($sql);
//    $stmt->bindParam(1, $userID);
//    if ($stmt->execute()) {
//        return true;
//    } else {
//        return false;
//    }


}


?>