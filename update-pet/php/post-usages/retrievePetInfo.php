<?php

    require_once "../DBConnect.php";

    $conn = databaseConnect("Pet");
    $sql = "SELECT * from Pets Where id = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($_POST["pet_id"]));
    $execute = sqlsrv_execute($stmt);
    if ($execute) {
        
    } else {
        sqlsrv_close($conn);
        return "SQL Connection Error: " . sqlsrv_errors();
    }

?>