<?php

$dbServerName = "aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com"; 
$dbUsername = "teampurple2999capstone";
$dbPassword = "\$teamPurple!";
$dbName = "HelloWorld"; 

$connectionInfo = array("UID" => $dbUsername, "PWD" => $dbPassword,"Database" => $dbName);

$conn = sqlsrv_connect($dbServerName, $connectionInfo);



function insertTime() {

    $queryInsert = "INSERT INTO TimeStamp (time) values (?)";
    $stmt = sqlsrv_query($conn, $queryInsert);

    if ($stmt === false):
        echo "Sql Server Error: " . sqlsrv_errors();
    
    else : 

        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            echo "alert('" . $row["time"] . "');";
        }

    endif;

    sqlsrv_close($conn);
}



?>