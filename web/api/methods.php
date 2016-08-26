<?php

function getClinics($mysqli)
  {
    $SQLString = "SELECT * FROM TBL_CLINIC";
    $QueryResult = $mysqli->query($SQLString);
    $clinics = array();
     if($QueryResult == TRUE)
     {
       while (($Row = $QueryResult->fetch_assoc()) !== NULL)
       {
         $rowid = $Row['ID'];
         $clinics[$rowid] = array();
         $clinics[$rowid]['clinic_id'] = $Row['CLINIC_ID'];
         $clinics[$rowid['address-id'] = $Row['ADDRESS_ID'];
         $clinics[$rowid['contact_1'] = $Row['CONTACT_1'];
         $clinics[$rowid['contact_2'] = $Row['CONTACT_2'];
         $clinics[$rowid['description'] = $Row['DESCRIPTION'];
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
