
<?php

    include_once ("./DBConnect.php");
    
    try{
    $conn = databaseConnect("Pet"); 
    $sql = "select * from Locations where id=?";
    $statement = sqlsrv_prepare($conn,$sql,array($_POST["location_ID"]));
    $execute = sqlsrv_execute($statement);

    $arrkeyvalues;
    if ($execute){
        while ($row = sqlsrv_fetch_object($statement)){
            $arrkeyvalues = array("Name" => $row->business, "Street" => $row->address, "City" => $row->city, "State" => $row->state, "Zip" => $row->zip, "Email" => $row->email, "Phone" => $row->phoneNumber, "vetService" => $row->veterinary, "groomService" => $row->groom, "boardService" => $row->board);
        }
    }
    
    sqlsrv_close($conn);
    
    echo json_encode($arrkeyvalues);

    } catch (Throwable $e){	
    echo "Throwable error " . $e;
    }

?>