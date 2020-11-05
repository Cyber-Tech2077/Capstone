<?php
	
require_once "./DBConnect.php";

$connection = databaseConnect("Pet");
try {
	$sql = "Insert into PetHistory (petId, serviceName, date) values (?, ?, ?)";
$statement = sqlsrv_prepare($connection, $sql, array($_POST["petId"], $_POST["petName"], $_POST["serviceDate"]) );
$final = sqlsrv_execute($statement);
if ($final === false){
	return "SQL Server Error: " . sqlsrv_errors();
}

} catch (Throwable $e) {
	return "Throwable error: " . $e;
	
	
}



?>