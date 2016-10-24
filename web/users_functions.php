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


?>