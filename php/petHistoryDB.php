<?php

include_once ("../php/DBConnect.php");
//require_once ("../pages/pet_history.php");


try 
{
    $conn = databaseConnect("Pet");

    
    $param = array($_POST["pet_id"]);
    
    $sql = "SELECT * FROM PetHistory WHERE petId=? ORDER BY date";
    //$stmt = sqlsrv_query($conn, $sql);
    $stmt = sqlsrv_prepare($conn,$sql,$param);

    $execute = sqlsrv_execute($stmt);

    $rowKeyValues = array();
    if($execute){
        
            //$rowKeyValues = array("Service0" => "No Services");
            
            $num = 0;
            while($row = sqlsrv_fetch_object($stmt)) {
                
                $jsonService = "Service" . $num;
                $jsonDate = "Date" . $num;
                $jsonLocation = "Location" . $num;

                //change date format to string
                $sqlDate = $row->date;
                $dateString =$sqlDate->format('Y-m-d');

                $instance = array(
                                    $jsonService =>$row->serviceName, 
                                    $jsonDate =>$dateString, 
                                    $jsonLocation =>$row->locationId
                                );
                $rowKeyValues = array_merge($rowKeyValues, $instance);

                $num++;
            }
    
    } else {
        $rowKeyValues = array("Service0" => "No Services");
    }

    //print_r($rowKeyValues);
        
    //send array of files to pet_history.php;
    echo json_encode($rowKeyValues);
    
} catch (Throwable $e) {
    echo "Throwable Caught: " . $e;
} catch (Exception $ee) {
    echo "Exception Caught: " . $ee;
}

sqlsrv_close($conn);
?>