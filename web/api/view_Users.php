<?php

header("content-type:application/json");
require_once("DBConn.php");
require_once("methods.php");

$clinics = array();
$clinics = getClinics($mysqli, $id);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($clinics);

exit();

?>
