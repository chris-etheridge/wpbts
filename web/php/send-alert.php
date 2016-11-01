<?php
ini_set('display_errors', 1);
session_start();

require_once("DBConn.php");

//variables used to store alert message before sending
$alertbody;
$alerttitle;

//get alert from db or parse custom alert
if(isset($_GET['alertid'])) //preset alert
{
    $alertid = $mysqli->real_escape_string($_GET['alertid']); //filter post
    $sql = "SELECT * FROM TBL_ALERT WHERE ALERT_ID = $alertid";
    $QueryResult = $mysqli->query($sql);
    $alert = array();
    if ($QueryResult == TRUE)
    {
        $rowid = 0;
        while (($Row = $QueryResult->fetch_assoc()) !== NULL)
        {
            $alert[$rowid] = array();
            $alert[$rowid]['alertid'] = $Row['ALERT_ID'];
            $alert[$rowid]['description'] = $Row['DESCRIPTION'];
            $alert[$rowid]['body'] = $Row['BODY'];
            $alert[$rowid]['title'] = $Row['TITLE'];
        }
        $alertbody = $alert[0]['body'];
        $alerttitle = $alert[0]['title'];
    }
    else
    {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Warning!";
        $_SESSION['alert']['message'] = "There was an error finding the alert in the database.";
        header('Location: ../alerts.php');
        exit();
    }
}
else //custom alert
{
    if(isset($_POST['custom_alert'])) //parse custom alert components
    {
        $alertbody = $_POST['custom_alert']['body'];
        $alerttitle = $_POST['custom_alert']['title'];
    }
    else
    {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Warning!";
        $_SESSION['alert']['message'] = "No alert data to send.";
        header('Location: ../alerts.php');
        exit();
    }
}



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
        'title' => $alerttitle,
        'body' => $alertbody
    ),
    'to' => "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ"
);

$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . $FCMServerKey,
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $FCMurl );
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