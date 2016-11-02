<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");
require_once("../api/clinics/functions.php");
require_once("upload-image.php");

session_start();

//add variables to session for to post them back to referrer if error occured
$_SESSION['clinic']['description'] = $_POST['description'];
$_SESSION['clinic']['contact_1'] = $_POST['contact_1'];
$_SESSION['clinic']['contact_2'] = $_POST['contact_2'];
$_SESSION['clinic']['operating_hours'] = $_POST['operating_hours'];

$_SESSION['clinic']['street_no'] = $_POST['street_no'];
$_SESSION['clinic']['street'] = $_POST['street'];
$_SESSION['clinic']['area'] = $_POST['area'];
$_SESSION['clinic']['city'] = $_POST['city'];
$_SESSION['clinic']['area_code'] = $_POST['area_code'];
$_SESSION['clinic']['building_number'] = $_POST['building_number'];
$_SESSION['clinic']['office'] = $_POST['office'];

if(        !isset($_POST['description']) || !isset($_POST['contact_1'])
        || !isset($_POST['contact_2']) || !isset($_POST['street_no']) || !isset($_POST['street'])
        || !isset($_POST['area']) || !isset($_POST['city']) || !isset($_POST['area_code'])
        || !isset($_POST['operating_hours'])) //verify everything crucial was posted
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//setting local variables to filtered post values for sql statements
$description = $mysqli->real_escape_string($_POST['description']);
$contact1 = $mysqli->real_escape_string($_POST['contact_1']);
$contact2 = $mysqli->real_escape_string($_POST['contact_2']);
$operatinghours = $mysqli->real_escape_string($_POST['operating_hours']);

$streetno = $mysqli->real_escape_string($_POST['street_no']);
$street = $mysqli->real_escape_string($_POST['street']);
$suburb = $mysqli->real_escape_string($_POST['area']);
$city = $mysqli->real_escape_string($_POST['city']);
$zip = $mysqli->real_escape_string($_POST['area_code']);
$office = $mysqli->real_escape_string($_POST['office']);
$buildingno = $mysqli->real_escape_string($_POST['building_number']);
$buildingno = (!$buildingno) ? "NULL" : $buildingno; //so db lets us ommit building number

/* INSERT/ UPDATE ADDRESS*/

$sql = "INSERT INTO TBL_ADDRESS (STREET_NO, STREET, AREA, CITY, AREA_CODE, OFFICE, BUILDING_NUMBER) VALUES($streetno, '$street', '$suburb', '$city', '$zip',  '$office', $buildingno)";

$mysqli->query($sql);
$insertedAddressID = $mysqli->insert_id;

if($mysqli->error)
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error creating address details!" . $sql . " ___ " . $mysqli->error;
    $_SESSION['alert']['message'] = "Please review the address fields. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/* INSERT/ UPDATE CLINIC*/

$sql = "INSERT INTO TBL_CLINIC (DESCRIPTION, CONTACT_1, CONTACT_2, ADDRESS_ID, OPERATING_HOURS) "
            . " VALUES('$description', '$contact1', '$contact2', $insertedAddressID, '$operatinghours');";

$mysqli->query($sql);
$clinicid = $mysqli->insert_id;

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error creating clinic!";
    $_SESSION['alert']['message'] = "Please review the clinic details. If problem persists, contact system administrator!" ;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//upload image
if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]['size'] > 0)
{
    $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
    $target_file =  "../img/clinics/" . $target_dir . $clinicid . "." .$ext;
    $response = uploadImage($_FILES['fileToUpload'], $target_file);
    
    if(isset($response))
    {
        //redirect back to previous page with error message
        $_SESSION['alert']['message_type'] = "alert-warning";
        $_SESSION['alert']['message_title'] = "Warning";
        $_SESSION['alert']['message'] = $response;
        header('Location: ../clinics.php');
        exit();
    }
}

//redirect back to previous page with success message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Clinic created successfully.";
$_SESSION['event'] = null; //clear sticky form data
header('Location: ../clinics.php');
exit();
