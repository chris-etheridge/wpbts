<?php
//author = Kyle Burton

require_once("DBConn.php");
require_once("../api/events/functions.php");
require_once("upload-image.php");

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
$_SESSION['event']['office'] = $_POST['office'];
$_SESSION['event']['building_number'] = $_POST['building_number'];
$_SESSION['event']['longitude'] = $_POST['longitude'];
$_SESSION['event']['latitude'] = $_POST['latitude'];

$_SESSION['event']['event_id'] = $_POST['event_id'];
$_SESSION['event']['address_id'] = $_POST['address_id'];

if(        !isset($_POST['event_id']) || !isset($_POST['title'])
        || !isset($_POST['description']) || !isset($_POST['event_date']) || !isset($_POST['type_id'])
        || !isset($_POST['event_admin']) || !isset($_POST['street_no']) || !isset($_POST['street'])
        || !isset($_POST['area']) || !isset($_POST['city']) || !isset($_POST['area_code'])
        || !isset($_POST['address_id']) || !isset($_POST['active'])
        || !isset($_POST['longitude']) || !isset($_POST['latitude'])) //verify everything crucial was posted
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Error!";
    $_SESSION['alert']['message'] = "Not all fields were completed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//setting local variables to filtered post values for sql statements
$eventid = $mysqli->real_escape_string($_POST['event_id']);
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
$office = $mysqli->real_escape_string($_POST['office']);
$buildingno = $mysqli->real_escape_string($_POST['building_number']);
$longitude = $mysqli->real_escape_string($_POST['longitude']);
$latitude = $mysqli->real_escape_string($_POST['latitude']);

$buildingno = (!$buildingno) ? "NULL" : $buildingno; //so db lets us ommit building number
$longitude = (!$longitude) ? "NULL" : $longitude; //so db lets us ommit longitude
$latitude = (!$latitude) ? "NULL" : $latitude; //so db lets us ommit latitude



/* INSERT/ UPDATE ADDRESS*/
$sql = "UPDATE TBL_ADDRESS SET STREET_NO = $streetno, STREET = '$street', " 
        . "AREA = '$suburb', CITY = '$city', AREA_CODE = '$zip', OFFICE = '$office', BUILDING_NUMBER = $buildingno, " 
        . " LONGITUDE = $longitude, LATITUDE = $latitude WHERE ADDRESS_ID = $addressid";

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
    $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
    $target_file =  "../img/events/" . $target_dir . $eventid . "." .$ext;
    $response = uploadImage($_FILES['fileToUpload'], $target_file);
    
    if(isset($response))
    {
        //redirect back to previous page with error message
        $_SESSION['alert']['message_type'] = "alert-warning";
        $_SESSION['alert']['message_title'] = "Warning";
        $_SESSION['alert']['message'] = $response;
        header('Location: ../events.php');
        exit();
    }
}

//redirect back to previous page with success message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Event updated successfully.";

$_SESSION['event'] = null; //clear sticky form data
header('Location: ../events.php');
exit();
