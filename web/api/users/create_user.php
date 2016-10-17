<?php

header("content-type:application/json");
require_once("../../php/DBConn_Dave.php");

//JSON STRING
function createUser($userData, $addressID = null)
{

    //From ADMIN console: JSON Array of Address and Userdata
    //then initiate the registration flow.

    //From ANDROID APP:
    //Hits registration method and returns here at end to create the records.
    global $dbConn;

    if ($addressID == null) {
        registerUser($userData);
    }

    $lastUserID = (int)getLastIDForTable("TBL_USER", "USER_ID") + 1;
    $userData['PWD'] = md5($userData['PWD']);
    $userData['ADDRESS_ID'] = $addressID;

    $sql = "INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, NATIONAL_ID, EMAIL,
        PHONE, BLOOD_TYPE, ADDRESS_ID, DATE_OF_BIRTH, TITLE,
        GENDER, LANGUAGE_PREF, PASSPORT_NUM, PWD)
      VALUES(?,?,?,?,?,
            ?,?,?,?,?,
            ?,?,?,?)";

    $stmt = $dbConn->prepare($sql);

    $stmt->bindParam(1, $lastUserID);
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
        issueError('112');//OK

    } else {
        print_r($stmt->errorInfo());
        //issueError('113');
    }
}

//CALLED BY THE ANDROID GUYS TO REGISTER A NEW PERSON.
//ALSO CALLED BY THE CREATE USER METHOD, IF AND WHEN A NEW USER IS CREATED.
function registerUser($userData)
{
    $userData = json_decode($userData, true);
    if ($userData == null) {
        issueError('115');
    }
    $userData = prepareData($userData);

    if (doesUserExist($userData[0]['EMAIL'])) {
        issueError('111');
    }
    $addresCheck = doesAddressExist($userData[1]);
    if ($addresCheck != false) {
//        echo "address exists";
        createUser($userData[0], $addresCheck[1]);
    } else {
//        echo "addres does not exist:";
        $lastID = createAddress($userData[1]);
        //echo $lastID;
        createUser($userData[0], $lastID);
    }
}


function createAddress($address)
{
    global $dbConn;
    $sql = "INSERT INTO TBL_ADDRESS(ADDRESS_ID, CITY, OFFICE, STREET, AREA, AREA_CODE, BUILDING_NUMBER) 
          VALUES (?,?,?,?,?,?,?)";

    $lastID = getLastIDForTable("TBL_ADDRESS", "ADDRESS_ID");
    $lastID = (int)$lastID + 1;

    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $lastID);
    $stmt->bindParam(2, $address['CITY']);
    $stmt->bindParam(3, $address['OFFICE']);
    $stmt->bindParam(4, $address['STREET']);
    $stmt->bindParam(5, $address['AREA']);
    $stmt->bindParam(6, $address['AREA_CODE']);
    if ($address["BUILDING_NUMBER"] = "") {
        $address["BUILDING_NUMBER"] = 0;
    } else {
        $address["BUILDING_NUMBER"] = (int)$address["BUILDING_NUMBER"];
    }
    $stmt->bindParam(7, $address["BUILDING_NUMBER"]);
    if ($stmt->execute() == false) {
        print_r($stmt->errorInfo());
        issueError('113');
    }
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
    $stmt = "SELECT ADDRESS_ID FROM TBL_ADDRESS WHERE CITY=? AND OFFICE=? AND STREET=? AND AREA=? AND AREA_CODE = ? AND BUILDING_NUMBER=?";
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
    $USER_NOT_EXISTS = "111 - User already exist";
    $LOGIN_ACCEPTED = "112 - Registration Accepted";
    $DATABASE_UNABAILABLE = "113 - Database unavailable - check server logs";
    $SCRIPT_UNAVAILABLE = "114 - Script not implemented";
    $INCORRECT_JSON = "115 - Incorrect string format";
    $INCORRECT_PARAMATER_COUNT = "116 - Incomplete paramaters. Expect min 12 user, 6 address";

    switch ($errCode) {
        case '111':
            echo $USER_NOT_EXISTS;
            break;
        case '112':
            echo $LOGIN_ACCEPTED;
            break;
        case '113':
            echo $DATABASE_UNABAILABLE;
            break;
        case '114':
            echo $SCRIPT_UNAVAILABLE;
            break;
        case'115':
            echo $INCORRECT_JSON;
            break;
        case '116':
            echo $INCORRECT_PARAMATER_COUNT;
            break;
    }
    die();
}

?>