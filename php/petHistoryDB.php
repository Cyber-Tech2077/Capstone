<?php

include_once ("../php/.DBConnectphp");
//require_once ("../pages/pet_history.php");


try 
{
    $conn = databaseConnect("Pet");

    //var_dump($_POST["pet_name"]);
    $param = array($_POST["pet_id"]);
    //$param = 5;
    
    $sql = "SELECT * FROM PetHistory WHERE petId=?";
    //$stmt = sqlsrv_query($conn, $sql);
    $stmt = sqlsrv_prepare($conn,$sql,$param);

    $execute = sqlsrv_execute($stmt);

    $rowKeyValues;
    if($execute){
        
        $num = 0;
        while($row = sqlsrv_fetch_object($stmt)) {
            $jsonName = "Service" . $num++;
            $rowKeyValues = array($jsonName =>$row->serviceName);
            //$num++;

            
        }
        
    }

    sqlsrv_close($conn);
        
    //echo $rowKeyValues;
    echo json_encode($rowKeyValues);
    
} catch (Throwable $e) {
    echo "Throwable Caught: " . $e;
} catch (Exception $ee) {
    echo "Exception Caught: " . $ee;
}

    //sqlsrv_close($conn);

?>