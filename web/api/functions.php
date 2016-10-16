<?php
function getClinics($mysqli, $clinicid = 0)
{
    $SQLString = "SELECT * FROM VIEW_CLINICSWADDRESS";
    if (is_numeric($clinicid) && $clinicid != 0)
    {
        $SQLString .= " WHERE CLINIC_ID = " . $clinicid;
    }

    $QueryResult = $mysqli->query($SQLString);
    $clinics = array();
    if ($QueryResult == TRUE)
    {
        $rowid = 0;
        while (($Row = $QueryResult->fetch_assoc()) !== NULL)
        {
            $clinics[$rowid] = array();
            $clinics[$rowid]['clinic_id'] = $Row['CLINIC_ID'];
            $clinics[$rowid]['address_id'] = $Row['ADDRESS_ID'];
            $clinics[$rowid]['contact_1'] = $Row['CONTACT_1'];
            $clinics[$rowid]['contact_2'] = $Row['CONTACT_2'];
            $clinics[$rowid]['description'] = $Row['DESCRIPTION'];
            $clinics[$rowid]['city'] = $Row['CITY'];
            $clinics[$rowid]['office'] = $Row['OFFICE'];
            $clinics[$rowid]['street'] = $Row['STREET'];
            $clinics[$rowid]['area'] = $Row['AREA'];
            $clinics[$rowid]['area_code'] = $Row['AREA_CODE'];
            $clinics[$rowid]['building_number'] = $Row['BUILDING_NUMBER'];
            $rowid++;
        }
    }
    else
    {
        echo "COULD NOT FETCH ITEMS";
        echo $mysqli->error;
    }
    return $clinics;
}

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
            $events[$rowid]['address_id'] = $Row['ADDRESS_ID'];
            $events[$rowid]['type_id'] = $Row['TYPE_ID'];
            $events[$rowid]['description'] = $Row['DESCRIPTION'];
            $events[$rowid]['title'] = $Row['TITLE'];
            $events[$rowid]['active'] = $Row['ACTIVE'];
            $events[$rowid]['city'] = $Row['CITY'];
            $events[$rowid]['office'] = $Row['OFFICE'];
            $events[$rowid]['street'] = $Row['STREET'];
            $events[$rowid]['area'] = $Row['AREA'];
            $events[$rowid]['area_code'] = $Row['AREA_CODE'];
            $events[$rowid]['building_number'] = $Row['BUILDING_NUMBER'];
            $events[$rowid]['type_description'] = $Row['TYPE_DESCRIPTION'];
            $events[$rowid]['urgency'] = $Row['URGENCY'];
            $rowid++;
        }

        //var_dump($events);
    }
    else
    {
        echo "COULD NOT FETCH ITEMS";
        echo $mysqli->error;
    }
    return $events;
}

?>
