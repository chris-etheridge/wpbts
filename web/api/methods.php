<?php

function getClinics($mysqli, $clinicid)
  {
    $SQLString = "SELECT * FROM VIEW_CLINICSWADDRESS";
    if($clinicid != 0)
    {
      $SQLString += " WHERE CLINIC_ID = " . $clinicid;
    }

    $QueryResult = $mysqli->query($SQLString);
    $clinics = array();
     if($QueryResult == TRUE)
     {
       while (($Row = $QueryResult->fetch_assoc()) !== NULL)
       {
         $rowid = $Row['CLINIC_ID'];
         $clinics[$rowid] = array();
         $clinics[$rowid]['clinic_id'] = $Row['CLINIC_ID'];
         $clinics[$rowid]['address-id'] = $Row['ADDRESS_ID'];
         $clinics[$rowid]['contact_1'] = $Row['CONTACT_1'];
         $clinics[$rowid]['contact_2'] = $Row['CONTACT_2'];
         $clinics[$rowid]['description'] = $Row['DESCRIPTION'];
         $clinics[$rowid]['city'] = $Row['CITY'];
         $clinics[$rowid]['office'] = $Row['OFFICE'];
         $clinics[$rowid]['street'] = $Row['STREET'];
         $clinics[$rowid]['area'] = $Row['AREA'];
         $clinics[$rowid]['area_code'] = $Row['AREA_CODE'];
         $clinics[$rowid]['building_number'] = $Row['BUILDING_NUMBER'];
       }
     }
     else
     {
      echo "COULD NOT FETCH ITEMS";
      echo $mysqli->error;
     }
    return $clinics;
  }

?>
