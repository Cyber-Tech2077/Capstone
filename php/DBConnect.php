<?php

function databaseConnect($database) {
            
    $username = "teampurple2999capstone";
    $password = "$" . "teamPurple" . "!";
    // Assign $connectionInfo to array of key-value pairs
    $connectionInfo = array("UID" => $username,
                            "PWD" => $password,
                            "Database" => $database);
    return sqlsrv_connect("aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com,1433", $connectionInfo);
}