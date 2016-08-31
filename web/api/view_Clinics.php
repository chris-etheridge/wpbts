<?php

header("content-type:application/json");
require_once("../php/DBConn.php");
require_once("methods.php");

$clinicid = 0;
$clinics = array();
if (isset($_POST['clinicid']))
{
  $clinicid = $_POST['clinicid'];
}
$clinics = getClinics($mysqli, $clinicid);

// $_POST['page'] tells us which array of results to load.
// this can be more complex once you implement a functional database.
echo json_encode($clinics);

exit();

?>
