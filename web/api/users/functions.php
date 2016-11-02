<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/17
 * Time: 5:48 PM
 */


require_once("../../php/DBConn_Dave.php");


function updateUser($addressID, $lastEmail, $userData)
{

    global $dbConn;

    $sql = "UPDATE TBL_USER 
      SET FIRST_NAME = ?,
      LAST_NAME = ?,
      NATIONAL_ID=?,
      EMAIL=?,
      PHONE=?,
      BLOOD_TYPE=?,
      ADDRESS_ID = ?,
      DATE_OF_BIRTH = ?,
      TITLE = ?,
      GENDER = ?,
      LANGUAGE_PREF=?,
      PASSPORT_NUM=?,
      PWD = ?
      WHERE EMAIL = '$lastEmail'";

    $userData['PWD'] = sha1($userData['PWD']);

    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $userData['FIRST_NAME']);
    $stmt->bindParam(2, $userData['LAST_NAME']);
    $stmt->bindParam(3, $userData['NATIONAL_ID']);
    $stmt->bindParam(4, $userData['EMAIL']);
    $stmt->bindParam(5, $userData['PHONE']);
    $stmt->bindParam(6, $userData['BLOOD_TYPE']);
    $stmt->bindParam(7, $addressID);
    $stmt->bindParam(8, $userData['DATE_OF_BIRTH']);
    $stmt->bindParam(9, $userData['TITLE']);
    $stmt->bindParam(10, $userData['GENDER']);
    $stmt->bindParam(11, $userData['LANGUAGE_PREF']);
    $stmt->bindParam(12, $userData['PASSPORT_NUM']);
    $stmt->bindParam(13, $userData['PWD']);

    if ($stmt->execute() == false) {
        echo "Ensure you are passing the last know email address with this query.";
        print_r($stmt->errorInfo());
        die();
    }

    echo "112 - User updated successfully";

}

function updateAddress($addresID, $addressInfo)
{
    global $dbConn;
    $sql = "UPDATE TBL_ADDRESS
        SET 
        STREET_NO = ?,
        CITY = ?,
        OFFICE = ?,
        STREET = ?,
        AREA = ?,
        AREA_CODE = ?,
        BUILDING_NUMBER = ?
        WHERE
        ADDRESS_ID = $addresID
        ";

    $blgNum = (int)$addressInfo['BUILDING_NUMBER'];

    $stmt = $dbConn->prepare($sql);

    $stmt->bindParam(1, $addressInfo['STREET_NO']);
    $stmt->bindParam(2, $addressInfo['CITY']);
    $stmt->bindParam(3, $addressInfo['OFFICE']);
    $stmt->bindParam(4, $addressInfo['STREET']);
    $stmt->bindParam(5, $addressInfo['AREA']);
    $stmt->bindParam(6, $addressInfo['AREA_CODE']);
    $stmt->bindParam(7, $blgNum);
    if ($stmt->execute() == false) {
        echo "Ensure you are passing the last know email address with this query.";
        print_r($stmt->errorInfo());
    }
}

function getAddressID($email)
{
    echo $email;
    global $dbConn;
    $sql = "SELECT ADDRESS_ID FROM TBL_USER WHERE EMAIL = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $email);
    if ($stmt->execute() == false) {
        echo "Ensure u have passed the correct LAST email with the new user details, even if the address remains the same.";
        print_r($stmt->errorInfo());

    }
    $res = $stmt->fetch();
    return $res['ADDRESS_ID'];
}


function getHashedPassword($userEmail)
{
    global $dbConn;
    $sql = "SELECT PWD FROM TBL_USER WHERE EMAIL = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $userEmail);
    if ($stmt->execute() == false) {
        print_r($stmt->errorInfo());
        issueError('113');
    }
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res;
}

function doesEmailAddressExist($email)
{
    $res = getUserEmailAddress($email);
//    var_dump($res);
    if ($res == null) {
        return false;
    } else {
        return true;
    }
}

function getUserEmailAddress($emailAddress)
{
    global $dbConn;

    $sql = "SELECT EMAIL FROM TBL_USER WHERE EMAIL = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $emailAddress);
    if ($stmt->execute() == false) {
        echo "114 - Database error";
        echo print_r($stmt->errorInfo());
        die();
    }
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res;
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

    $lastID = getLastIDForTable("TBL_ADDRESS", "ADDRESS_ID");
    $lastID = (int)$lastID + 1;

    var_dump($address);

    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $lastID);
    $stmt->bindParam(2, $address['STREET_NO']);
    $stmt->bindParam(3, $address['CITY']);
    $stmt->bindParam(4, $address['OFFICE']);
    $stmt->bindParam(5, $address['STREET']);
    $stmt->bindParam(6, $address['AREA']);
    $stmt->bindParam(7, $address['AREA_CODE']);
    if ($address["BUILDING_NUMBER"] = "") {
        $address["BUILDING_NUMBER"] = 0;
    } else {
        $address["BUILDING_NUMBER"] = (int)$address["BUILDING_NUMBER"];
    }
    $stmt->bindParam(8, $address["BUILDING_NUMBER"]);

    if ($stmt->execute() == false) {
        print_r($stmt->errorInfo());
        issueError('113');
    }
    echo "address created/";
    return $lastID;
}

function getLastIDForTable($tableName, $column)
{

    global $dbConn;
    $sql = "select $column from $tableName ORDER BY $column DESC LIMIT 1";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res[$column];

}

//checks and returns address ID if an address exists for a new user
//in which case we must link the addresses
function doesAddressExist($userAddressFromWeb)
{
    global $dbConn;
    //var_dump($userAddressFromWeb);
    $stmt = "SELECT ADDRESS_ID FROM TBL_ADDRESS WHERE CITY =? AND OFFICE =? AND STREET =? AND AREA =? AND AREA_CODE = ? AND BUILDING_NUMBER =?";
    $stmt = $dbConn->prepare($stmt);
    //$stmt->execute(array('BERLIN', '6', 'P.O. BOX 622, 1849 EU ST.', 'BE', '78059', '6'));
    $stmt->execute(array($userAddressFromWeb['CITY'], $userAddressFromWeb['OFFICE'], $userAddressFromWeb['STREET'], $userAddressFromWeb['AREA'], $userAddressFromWeb['AREA_CODE'], $userAddressFromWeb["BUILDING_NUMBER"]));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($result);

    if ($result != null) {
        return array(true, $result["ADDRESS_ID"]);
    } else {
        return false;
    }
}

//checks to see if a user exists.
function doesUserExist($userEmail)
{
    global $dbConn;
    $doesExist = false;
    $stm = "SELECT EMAIL FROM TBL_USER WHERE EMAIL = ?";
    $stmt = $dbConn->prepare($stm);
    $stmt->bindParam(1, $userEmail);
    $stmt->execute();
    $result = $stmt->fetch();
//    print_r('result' . $result);
    if ($result != null) {
        $doesExist = true;
    }
    return $doesExist;
}

//Makes all data lower case and if null ""
function prepareData($userData)
{
    $userData[0] = array_change_key_case($userData[0], CASE_UPPER);
    $userData[1] = array_change_key_case($userData[1], CASE_UPPER);
    foreach ($userData[0] as $key => &$item) {
        if ($item == null) {
            $item = "";
        }
        $item = strtoupper($item);
        //echo $item;
    }
    //FOR ADDRESS INFO.
    foreach ($userData[1] as $key => &$item) {
        if ($item == null) {
            $item = "";
        }
        $item = strtoupper($item);
        //echo $item;
    }
    if (key_exists('ADDRESS_ID', $userData[1]) == false) {
        $userData['ADDRESS_ID'] = "";
    }


    return $userData;
}

function issueError($errCode)
{
    $USER_NOT_EXISTS = array('code' => "111", 'message' => "User already exist");
    $LOGIN_ACCEPTED = array('code' => "112", 'message' => "Registration Accepted");
    $DATABASE_UNABAILABLE = array('code' => "113", 'message' => "Database unavailable - check server logs");
    $SCRIPT_UNAVAILABLE = array('code' => "114", 'message' => "Script not implemented");
    $INCORRECT_JSON = array('code' => "115", 'message' => "Incorrect string format");
    $INCORRECT_PARAMATER_COUNT = array('code' => "116", 'message' => "Incomplete paramaters . Expect min 12 user, 6 address");

    switch ($errCode) {
        case '111':
            echo json_encode($USER_NOT_EXISTS);
            break;
        case '112':
            echo json_encode($LOGIN_ACCEPTED);
            break;
        case '113':
            echo json_encode($DATABASE_UNABAILABLE);
            break;
        case '114':
            echo json_encode($SCRIPT_UNAVAILABLE);
            break;
        case'115':
            echo json_encode($INCORRECT_JSON);
            break;
        case '116':
            echo json_encode($INCORRECT_PARAMATER_COUNT);
            break;
    }
    die();
}


?>