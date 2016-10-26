<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("DBConn.php");
require_once("../api/events/functions.php");

session_start();

//add variables to session for to post them back to referrer if error occured
$_SESSION['event']['title'] = $_POST['title'];
$_SESSION['event']['description'] = $_POST['description'];
$_SESSION['event']['event_date'] = $_POST['event_date'];
$_SESSION['event']['type_id'] = $_POST['type_id'];
$_SESSION['event']['event_admin'] = $_POST['event_admin'];
$_SESSION['event']['active'] = $_POST['active'];

$_SESSION['event']['street_no'] = $_POST['street_no'];
$_SESSION['event']['street'] = $_POST['street'];
$_SESSION['event']['area'] = $_POST['area'];
$_SESSION['event']['city'] = $_POST['city'];
$_SESSION['event']['area_code'] = $_POST['area_code'];
$_SESSION['event']['creator_id'] = $_POST['creator_id'];
$_SESSION['event']['event_id'] = $_POST['event_id'];
$_SESSION['event']['address_id'] = $_POST['address_id'];

if(        !isset($_POST['event_id']) || !isset($_POST['creator_id']) || !isset($_POST['title'])
        || !isset($_POST['description']) || !isset($_POST['event_date']) || !isset($_POST['type_id'])
        || !isset($_POST['event_admin']) || !isset($_POST['street_no']) || !isset($_POST['street'])
        || !isset($_POST['area']) || !isset($_POST['city']) || !isset($_POST['area_code'])
        || !isset($_POST['address_id']) || !isset($_POST['active']))
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$eventid = $mysqli->real_escape_string($_POST['event_id']);
$creatorid = $mysqli->real_escape_string($_POST['creator_id']);
$title = $mysqli->real_escape_string($_POST['title']);
$description = $mysqli->real_escape_string($_POST['description']);
$date = $mysqli->real_escape_string($_POST['event_date']);
$typeid = $mysqli->real_escape_string($_POST['type_id']);
$adminid = $mysqli->real_escape_string($_POST['event_admin']);
$active = $mysqli->real_escape_string($_POST['active']);

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
    $_SESSION['alert']['message_title'] = "Error updating address details!";
    $_SESSION['alert']['message'] = "Please review the address fields. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

/* INSERT/ UPDATE EVENT*/
$sql = "UPDATE TBL_EVENT SET EVENT_DATE = STR_TO_DATE('$date', '%d-%m-%Y'), TYPE_ID = $typeid, " 
        . "DESCRIPTION = '$description', TITLE = '$title', ACTIVE = $active, "
        . "EVENT_ADMIN_ID = $adminid"
        . " WHERE EVENT_ID = $eventid;";

$mysqli->query($sql);

if($mysqli->error) //redirect user to edit/create page
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error updating event!";
    $_SESSION['alert']['message'] = "Please review the event details. If problem persists, contact system administrator!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//upload image
if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]['size'] > 0)
{
    $target_dir = "../img/events/";
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
$_SESSION['alert']['message'] = "Event updated successfully.";
$_SESSION['event'] = null; //clear sticky form data
header('Location: ../events.php');
exit();
