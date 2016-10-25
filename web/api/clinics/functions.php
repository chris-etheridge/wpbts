<?php

function getClinic($mysqli, $clinicid)
{
    $SQLString = "SELECT * FROM VIEW_CLINICSWADDRESS WHERE CLINIC_ID = $clinicid;";
    return getClinics($mysqli, $SQLString);
}

function getAllClinics($mysqli)
{
    $SQLString = "SELECT * FROM VIEW_CLINICSWADDRESS;";
    return getClinics($mysqli, $SQLString);
}


function getClinics($mysqli, $SQLString)
{
    $QueryResult = $mysqli->query($SQLString);
    $clinics = array();
    if ($QueryResult == TRUE)
    {
        $rowid = 0;
        while (($Row = $QueryResult->fetch_assoc()) !== NULL)
        {
            $clinics[$rowid] = array();
            $clinics[$rowid]['clinic_id'] = $Row['CLINIC_ID'];
            $clinics[$rowid]['description'] = $Row['DESCRIPTION'];
            $clinics[$rowid]['contact_1'] = $Row['CONTACT_1'];
            $clinics[$rowid]['contact_2'] = $Row['CONTACT_2'];
            
            $clinics[$rowid]['address_id'] = $Row['ADDRESS_ID'];
            $clinics[$rowid]['street_no'] = $Row['STREET_NO'];
            $clinics[$rowid]['street'] = $Row['STREET'];
            $clinics[$rowid]['area'] = $Row['AREA'];
            $clinics[$rowid]['area_code'] = $Row['AREA_CODE'];
            $clinics[$rowid]['city'] = $Row['CITY'];
            $clinics[$rowid]['office'] = $Row['OFFICE'];
            $clinics[$rowid]['building_number'] = $Row['BUILDING_NUMBER'];
            $rowid++;
        }
    }
    else
    {
        $errorMsg = array("code" => "332", "message" => $mysqli->error);
        return $errorMsg;
    }
    return $clinics;
}

?>
