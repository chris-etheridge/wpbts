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

    echo $userData['PWD'];
    echo sha1($userData['PWD']);

    $userData['PWD'] = sha1($userData['PWD']);
    $userData['ADDRESS_ID'] = $addressID;

    $sql = "INSERT INTO TBL_USER (USER_ID, FIRST_NAME, LAST_NAME, PWD,
        EMAIL, ADDRESS_ID, PHONE)
      VALUES(?,?,?,?,?,
            ?,?)";

    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $lastUserID);
    $stmt->bindParam(2, $userData['FIRST_NAME']);
    $stmt->bindParam(3, $userData['LAST_NAME']);
    $stmt->bindParam(4, $userData['PWD']);
    $stmt->bindParam(5, $userData['EMAIL']);
    $stmt->bindParam(6, $userData['ADDRESS_ID']);
    $stmt->bindParam(7, $userData['PHONE']);

    if ($stmt->execute()) {
        issueError('112');//OK

    } else {
        //print_r($stmt->errorInfo());
        issueError('113');
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


    if (doesUserExist($userData[0]['EMAIL']) == true) {
        issueError('111');
    }

    $addresCheck = doesAddressExist($userData[1]);
    if ($addresCheck != false) {
        //echo "address exists";
        //echo $addresCheck[1];
        createUser($userData[0], $addresCheck[1]);
    } else {
        $lastID = createAddress($userData[1]);
        //echo $lastID;
        createUser($userData[0], $lastID);
    }
}


?>