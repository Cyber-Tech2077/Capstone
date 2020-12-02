<?php
	require_once "./dynamic-queries/ConstructDBQueries.php";
	try {
		$dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => 'PetHistory'));
		foreach ($_POST as $postKey => $postValues) {
			$SQLConstruct = new SQL(json_decode($dbParams), json_decode($_POST[$postKey]));
    		$SQLConstruct->constructQueryWithParams();
		}
	} catch (Throwable $e) {
		return "Throwable error: " . $e;
	}
?>