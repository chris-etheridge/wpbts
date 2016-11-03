<?php

//author = Kyle Burton

header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

$clinics = getAllClinics($mysqli);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($clinics);

exit();