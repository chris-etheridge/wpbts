<?php

header("content-type:application/json");
require_once("../../php/DBConn_Dave.php");
require_once("functions.php");

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
        echo "creating user";
        createUser($userData[0], $addresCheck[1]);
    } else {
        echo "creating address and user";
//        echo "addres does not exist:";
        $lastID = createAddress($userData[1]);
        //echo $lastID;
        createUser($userData[0], $lastID);
    }
}


?>