<?php
ini_set('display_errors', 1);
session_start();

require_once("DBConn.php");
require_once ("notification_functions.php");


//variables used to store alert message before sending
$notificationbody;
$notificationtitle;

//get alert from db or parse custom alert
if(isset($_GET['notificationid'])) //preset alert
{
    $notificationid = $mysqli->real_escape_string($_GET['notificationid']); //filter post
    $sql = "SELECT * FROM TBL_ALERT WHERE ALERT_ID = $notificationid";
    $QueryResult = $mysqli->query($sql);
    $notification = array();
    if ($QueryResult == TRUE)
    {
        $rowid = 0;
        while (($Row = $QueryResult->fetch_assoc()) !== NULL)
        {
            $notification[$rowid] = array();
            $notification[$rowid]['notificationid'] = $Row['ALERT_ID'];
            $notification[$rowid]['description'] = $Row['DESCRIPTION'];
            $notification[$rowid]['body'] = $Row['BODY'];
            $notification[$rowid]['title'] = $Row['TITLE'];
        }
        $notificationbody = $notification[0]['body'];
        $notificationtitle = $notification[0]['title'];
    }
    else
    {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Warning!";
        $_SESSION['alert']['message'] = "There was an error finding the notification in the database.";
        header('Location: ../notifications.php');
        exit();
    }
}
else //custom alert
{
    if(isset($_POST['custom_alert'])) //parse custom alert components
    {
        $notificationbody = $_POST['custom_alert']['BODY'];
        $notificationtitle = $_POST['custom_alert']['TITLE'];
    }
    else
    {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Warning!";
        $_SESSION['alert']['message'] = "No notification data to send.";
        header('Location: ../notifications.php');
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

echo $notificationtitle;
echo "\n";
echo $notificationbody;
echo "\n";

$result = sendNotificationGlobal($notificationtitle, $notificationbody);



//return to alerts panel with message
$_SESSION['alert']['message_type'] = "alert-success";
$_SESSION['alert']['message_title'] = "SUCCESS!";
$_SESSION['alert']['message'] = "Alert sent successfully.";
//header('Location: ../alerts.php');

exit();