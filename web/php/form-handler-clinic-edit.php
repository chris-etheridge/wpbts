<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");
require_once("../api/clinics/functions.php");

session_start();

//add variables to session for to post them back to referrer if error occured
$_SESSION['clinic']['clinic_id'] = $_POST['clinic_id'];
$_SESSION['clinic']['description'] = $_POST['description'];
$_SESSION['clinic']['contact_1'] = $_POST['contact_1'];
$_SESSION['clinic']['contact_2'] = $_POST['contact_2'];

$_SESSION['clinic']['address_id'] = $_POST['address_id'];
$_SESSION['clinic']['street_no'] = $_POST['street_no'];
$_SESSION['clinic']['street'] = $_POST['street'];
$_SESSION['clinic']['area'] = $_POST['area'];
$_SESSION['clinic']['city'] = $_POST['city'];
$_SESSION['clinic']['area_code'] = $_POST['area_code'];

if(       !isset($_POST['clinic_id']) || !isset($_POST['description']) || !isset($_POST['contact_1'])
        || !isset($_POST['contact_2']) || !isset($_POST['street_no']) || !isset($_POST['street'])
        || !isset($_POST['area']) || !isset($_POST['city']) || !isset($_POST['area_code'])
        || !isset($_POST['address_id']))
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$clinicid = $mysqli->real_escape_string($_POST['clinic_id']);
$description = $mysqli->real_escape_string($_POST['description']);
$contact1 = $mysqli->real_escape_string($_POST['contact_1']);
$contact2 = $mysqli->real_escape_string($_POST['contact_2']);

$addressid = $mysqli->real_escape_string($_POST['address_id']);
$streetno = $mysqli->real_escape_string($_POST['street_no']);
$street = $mysqli->real_escape_string($_POST['street']);
$suburb = $mysqli->real_escape_string($_POST['area']);
$city = $mysqli->real_escape_string($_POST['city']);
$zip = $mysqli->real_escape_string($_POST['area_code']);

/* INSERT/ UPDATE ADDRESS*/
$sql = "UPDATE TBL_ADDRESS SET STREET_NO = $streetno, STREET = '$street', " 
        . "AREA = '$suburb', CITY = '$city', AREA_CODE = '$zip' " 
        . " WHERE ADDRESS_ID = $addressid";

$mysqli->query($sql);

if($mysqli->error)
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error updating details!";
    $_SESSION['alert']['message'] = "Please review the address fields. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/* INSERT/ UPDATE CLINIC*/

$sql = "UPDATE TBL_CLINIC SET DESCRIPTION = '$description', "
        . "CONTACT_1 = '$contact1', "
        . "CONTACT_2 = '$contact2'"
        . " WHERE CLINIC_ID = $clinicid;";

$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error updating clinic!";
    $_SESSION['alert']['message'] = "Please review the clinic details. If problem persists, contact system administrator!" ;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//upload image
if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]['size'] > 0)
{
    $target_dir = "../img/clinics/";
    $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
    $target_file = $target_dir . $clinicid . "." .$ext;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $rejectMessage = "";
    // Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false)
    {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else
    {
        $rejectMessage = "File is not an image.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000)
    {
        $rejectMessage = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
    {
        $rejectMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        //echo "Sorry, your file was not uploaded.";
        $_SESSION['alert']['message_type'] = "alert-warning";
        $_SESSION['alert']['message_title'] = "Warning";
        $_SESSION['alert']['message'] = "$rejectMessage Please Try again. If problem persists, contact system administrator!";
        header('Location: ../events.php');
        exit();
    } else // if everything is ok, try to upload file
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
            //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else
        {
            $_SESSION['alert']['message_type'] = "alert-warning";
            $_SESSION['alert']['message_title'] = "Warning";
            $_SESSION['alert']['message'] = "There was an error uploading your image. Please try again! If problem persists, contact system administrator!";
            header('Location: ../events.php');
            exit();
        }
    }
}

$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Clinic updated successfully.";
$_SESSION['event'] = null; //clear sticky form data
header('Location: ../clinics.php');
exit();
