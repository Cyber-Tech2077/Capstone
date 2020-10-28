<?php

include_once ("../php/DBConnect.php");

$conn = databaseConnect("Pet");

try {

    //var_dump($_POST["pet_name"]);
    
    $sql = "SELECT * FROM PetHistory";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        echo "Error Occurred: " . sqlsrv_errors();
    } else {
        while ($row = sqlsrv_fetch_object($stmt)) {
            //echo "<option name = 'petSelector' id = " . $row->id . " value = " . $row->name . ">" . $row->name . "</option>";
            echo "<tr> <th scope='row'>" . $row->id . "</th> <td>" . $row->serviceName . "</td> ";
        }
    }
    
} catch (Throwable $e) {
    echo "Throwable Caught: " . $e;
} catch (Exception $ee) {
    echo "Exception Caught: " . $ee;
}

sqlsrv_close($conn);

//Drop Down Selector for the Pets
function comboboxOptions() {

    $conn = databaseConnect("Pet");
    
    try {
        $sql = "select id, name from Pets";
        $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            echo "Error Occurred: " . sqlsrv_errors();
        } else {
            $storeValueId;
            while ($row = sqlsrv_fetch_object($stmt)) {
                echo "<option name = 'petSelector' id = " . $row->id . " value = " . $row->name . ">" . $row->name . "</option>";
            }
        }
    } catch (Throwable $e) {
        echo "Throwable Error: " . $e;
    }

    sqlsrv_close($conn);

}