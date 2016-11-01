<?php
ini_set('display_errors', 1);
session_start();

require_once("DBConn.php");


$url = 'https://fcm.googleapis.com/fcm/send';

/*$fields = array (
        'registration_ids' => array (
                "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ"
        ),
        'data' => array (
                "message" => "TEST MESSAGE"
        )
);*/

$fields = array(
    'message' => array(
        'title' => "test title",
        'body' => "test body"
    ),
    'to' => "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ"
);

$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . "AIzaSyAGqEvspvB03dZSawIjfp2xj_2lF1VRtmw",
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
//echo $result;
curl_close ( $ch );

$jsonResult = json_decode($result, true);

//parse the results field and replace ids where neccessary


var_dump($jsonResult);



if(isset($jsonResult) && $jsonResult['success'] === 0)
{
    $_SESSION['alert']['message_type'] = "alert-danger";
    $_SESSION['alert']['message_title'] = "Warning!";
    $_SESSION['alert']['message'] = "There was an error sending the alert. " . "$result";
    //header('Location: ../alerts.php');
    exit();
}

//return to alerts panel with message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Alert sent successfully.";
//header('Location: ../alerts.php');

exit();