<?php

    require_once "../DBConnect.php";

    $conn = databaseConnect("Pet");
    try {
        $sql = "SELECT * FROM Pets where id = ?";
        $stmt = sqlsrv_prepare($conn, $sql, array($_POST["pet_id"]));
        $execute = sqlsrv_execute($stmt);

        $arrNames;
        if ($execute) {
            while ($row = sqlsrv_fetch_object($stmt)) {
                $arrNames = array("Name" => $row->name, "Species" => $row->species, "Birthdate" => $row->birthdate, "Weight" => $row->weight, "Street" => $row->street, "City" => $row->city, "State" => $row->state, "Zip" => $row->zip);
            }
        } else {
            sqlsrv_close($conn);
            return "SQL Server Error: " . sqlsrv_error();
        }
        sqlsrv_close($conn);
        echo json_encode($arrNames);
    } catch (Throwable $e) {
        return "Throwable Error: " . $e;
    }
?>