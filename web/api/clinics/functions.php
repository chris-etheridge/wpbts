<?php
//author = Kyle Burton

//get a single clinics data with their addresses
function getClinic($mysqli, $clinicid)
{
    $SQLString = "SELECT * FROM VIEW_CLINICSWADDRESS WHERE CLINIC_ID = $clinicid;";
    return getClinics($mysqli, $SQLString);
}

//get all clinics with their addresses
function getAllClinics($mysqli)
{
    $SQLString = "SELECT * FROM VIEW_CLINICSWADDRESS;";
    return getClinics($mysqli, $SQLString);
}

//main method for selecting from DB
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
            $clinics[$rowid]['operating_hours'] = $Row['OPERATING_HOURS'];
            
            $clinics[$rowid]['address_id'] = $Row['ADDRESS_ID'];
            $clinics[$rowid]['street_no'] = $Row['STREET_NO'];
            $clinics[$rowid]['street'] = $Row['STREET'];
            $clinics[$rowid]['area'] = $Row['AREA'];
            $clinics[$rowid]['area_code'] = $Row['AREA_CODE'];
            $clinics[$rowid]['city'] = $Row['CITY'];
            $clinics[$rowid]['office'] = $Row['OFFICE']; //aka company names
            $clinics[$rowid]['building_number'] = $Row['BUILDING_NUMBER'];
            $clinics[$rowid]['longitude'] = $Row['LONGITUDE'];
            $clinics[$rowid]['latitude'] = $Row['LATITUDE'];
            
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
