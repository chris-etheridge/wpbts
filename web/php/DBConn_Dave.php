<?php

//Author = Dave (Connection for my local machine.)
//Will be included into the main scripts

//Local vars for connecting to the database.
$username = "root";
$password = "dvrootz2020$!";
$dsn = "mysql:host=localhost;dbname=sys";

//Create a PDO database connection and output error if exists killing the script
try {
    $dbConn = new PDO($dsn, $username, $password);
} catch (PDOException $exc) {
    echo $exc->getMessage();
    echo "113 - Database unavailable. Check server logs.";
    die();
}

?>