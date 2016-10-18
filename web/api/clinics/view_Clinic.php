<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


header("content-type:application/json");
require_once("../../php/DBConn.php");
require_once("functions.php");

$clinicid = $mysqli->real_escape_string($_POST['clinicid']);

$clinic = getClinics($mysqli, $clinicid);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($clinic);

exit();