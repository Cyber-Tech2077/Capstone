<?php

    require_once ("./DBConnect.php");

    $conn = databaseConnect("Pet");

    try {

        //sql statement
        $sql = "INSERT INTO PetHistory (petId, serviceName, date, locationId) VALUES (?, ?, ?, ?)";

        //data to pass into DB
        $arrayParams = array($_POST["pet_id"], "Boarding", $_POST["service_date"], $_POST["boarding_location"]);
    

        $stmt = sqlsrv_prepare($conn, $sql, $arrayParams);

        if (sqlsrv_execute($stmt) === false) {
            echo "SQL Statement Error: " . sqlsrv_errors(); 
        }


    } catch (Exception $e) {
        echo "Throwable Caught: " . $e;
    } catch (Throwable $ee) {
        echo "Exception caught: " . $ee;
    }

    sqlsrv_close($conn);

?>