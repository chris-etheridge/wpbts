<?php
function getEvent($mysqli, $eventid)
{
    $sql = "SELECT * FROM VIEW_EVENTSWADDRESS WHERE EVENT_ID = $eventid;";
    return getEvents($mysqli, $sql);
}

function getUpcommingEvents($mysqli) //returns only events that are active
{
    $sql = "SELECT * FROM VIEW_EVENTSWADDRESS WHERE STR_TO_DATE(EVENT_DATE, '%d-%m-%Y') > NOW() AND ACTIVE = 1;";
    return getEvents($mysqli, $sql);
}

function getAllUpcommingEvents($mysqli) //returns ALL future dated events
{
    $sql = "SELECT * FROM VIEW_EVENTSWADDRESS WHERE STR_TO_DATE(EVENT_DATE, '%d-%m-%Y') > NOW();";
    return getEvents($mysqli, $sql);
}

function getAllPastEvents($mysqli) //returns ALL future dated events
{
    $sql = "SELECT * FROM VIEW_EVENTSWADDRESS WHERE STR_TO_DATE(EVENT_DATE, '%d-%m-%Y') < NOW();";
    return getEvents($mysqli, $sql);
}

function getAllEvents($mysqli)
{
    $sql = "SELECT * FROM VIEW_EVENTSWADDRESS;";
    return getEvents($mysqli, $sql);
}

function getEvents($mysqli, $SQLString)
{
    $QueryResult = $mysqli->query($SQLString);
    $events = array();
    if ($QueryResult == TRUE)
    {
        $rowid = 0;
        while (($Row = $QueryResult->fetch_assoc()) !== NULL)
        {
            $events[$rowid] = array();
            $events[$rowid]['event_id'] = $Row['EVENT_ID'];
            $events[$rowid]['event_date'] = $Row['EVENT_DATE'];
            $events[$rowid]['description'] = $Row['DESCRIPTION'];
            $events[$rowid]['title'] = $Row['TITLE'];
            $events[$rowid]['active'] = $Row['ACTIVE'];
            $events[$rowid]['creator_id'] = $Row['CREATOR_ID'];
            $events[$rowid]['event_admin'] = $Row['EVENT_ADMIN_ID'];
            
            $events[$rowid]['address_id'] = $Row['ADDRESS_ID'];
            $events[$rowid]['city'] = $Row['CITY'];
            $events[$rowid]['office'] = $Row['OFFICE']; //aka company name
            $events[$rowid]['street_no'] = $Row['STREET_NO'];
            $events[$rowid]['street'] = $Row['STREET'];
            $events[$rowid]['area'] = $Row['AREA'];
            $events[$rowid]['area_code'] = $Row['AREA_CODE'];
            $events[$rowid]['building_number'] = $Row['BUILDING_NUMBER'];
            
            $events[$rowid]['type_id'] = $Row['TYPE_ID'];
            $events[$rowid]['type_description'] = $Row['TYPE_DESCRIPTION'];
            $events[$rowid]['urgency'] = $Row['URGENCY'];
            $rowid++;
        }

        //var_dump($events);
    }
    else
    {
        $errorMsg = array("code" => "222", "message" => $mysqli->error);
        return $errorMsg;
    }
    return $events;
}

function rsvp($mysqli, $eventid, $attending, $userid)
{
    $sql = "INSERT INTO TBL_EVENT_RSVP (USER_ID, EVENT_ID, ATTENDING) "
            . " VALUES ($userid, $eventid, $attending)"
            . " ON DUPLICATE KEY UPDATE ATTENDING = VALUES(ATTENDING);";
    
    $action = ((int)$attending === 1) ? "attending" : "not attending";
    
    $QueryResult = $mysqli->query($sql);
    $response;
    if ($QueryResult == TRUE)
    {
        $response = array("code" => "400", "success" => true, "message" => "You are successfully $action the event.");
    }
    else
    {
        $response = array("code" => "445", "message" => "An unknown DB error occured: " . $mysqli->error);
    }
    return $response;
}