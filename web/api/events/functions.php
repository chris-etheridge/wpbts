<?php
function getEvents($mysqli, $eventid = 0)
{
    $SQLString = "SELECT * FROM VIEW_EVENTSWADDRESS";
    if (is_numeric($eventid) && $eventid != 0)
    {
        $SQLString .= " WHERE EVENT_ID = " . $eventid;
    }

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
            
            $events[$rowid]['address_id'] = $Row['ADDRESS_ID'];
            $events[$rowid]['city'] = $Row['CITY'];
            $events[$rowid]['office'] = $Row['OFFICE'];
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

?>
