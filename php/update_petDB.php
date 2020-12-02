  
<?php

require_once ("./DBConnect.php");

try{

	$conn = databaseConnect("Pet"); 
	
	$sql = "UPDATE Pets SET name = ?, species = ?, birthdate = ?, weight = ?, street = ?, city = ?, state = ?, zip = ?, chipId = ? WHERE id = ?";
	$stmt;
	foreach (json_decode($_POST['pet']) as $paramKey => $paramValue) {
		$stmt = sqlsrv_prepare($conn, $sql, $paramValue);
	}

	if (sqlsrv_execute($stmt) === false) {
		echo 'Error: Please contact administrator';
	}
	
} catch (Throwable $e){
	
	echo "Throwable error " . $e;
	
} catch (Exception $ee) {
	echo 'Exception Error: ' . $ee;
}

?>