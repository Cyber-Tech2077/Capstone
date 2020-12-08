<?php

    include_once ("./DBConnect.php");
    
    try{
    $conn = databaseConnect("Pet"); 
    $sql = "select * from pets where id=?";
    $statement = sqlsrv_prepare($conn,$sql,array($_POST["pet_ID"]));
    $execute = sqlsrv_execute($statement);

    $arrkeyvalues;
    if ($execute){
        while ($row = sqlsrv_fetch_object($statement)){
            $arrkeyvalues = array("Name" => $row->name, "Species" => $row->species, "Birthdate" => $row->birthdate, "Weight" => $row->weight, "Street" => $row->street, "City" => $row->city, "State" => $row->state, "Zip" => $row->zip, "Chip" => $row->chipId, "HidePet" => $row->hidepet);
        }


    }
    
    sqlsrv_close($conn);
    
    echo json_encode($arrkeyvalues);

    } catch (Throwable $e){	
        echo "Throwable error " . $e;
    }
?>
