<?php

require_once("../../php/DBConn_Dave.php");

function createUser()
{

}

function registerUser($userData)
{

    $userData = json_decode($userData);
    var_dump($userData);

}

?>