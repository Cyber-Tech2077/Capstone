<?php

include_once ("../php/DBConnect.php");

{	 
    try {
        $conn = databaseConnect("Pet");
        $sql = "INSERT INTO PetHistory (petId, serviceName, date) VALUES (?,?,?)";   
        $params = array($_POST["pet_id"], "Grooming", $_POST["serviceDate"]);     
        $stmt = sqlsrv_prepare($conn, $sql, $params);
        if (sqlsrv_execute($stmt) === false) {
           echo "SQL Statement Error: " . sqlsrv_errors(); 
        }
   } catch (Throwable $e) {
       echo "Throwable Caught: " . $e;
   } catch (Exception $ee) {
       echo "Exception Caught: " . $ee;
   }
   sqlsrv_close($conn);
}

