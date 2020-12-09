<?php
	require_once '../php/dynamic-queries/ConstructDBQueries.php';
	class DataRetrieval {
		function getOptions(array $columns = array('*'), string $tableName = 'Pets') {
			$dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'select', 'tableName' => $tableName));
			$dbColumnNames;
			$dbColumnNames = json_encode($columns);
			$retrieveValues = new SQL($dbParams, $dbColumnNames);
			$arrayValues = json_decode($retrieveValues->constructSelectQueryAsArray());
			$options = '';
			foreach ($arrayValues as $arrayKey => $arrayValue) {
				foreach ($arrayValue as $optionKey => $optionValue) {
					switch (strtoupper($optionKey)) {
						case 'ID':
							$options .= '<option id = "' . $optionValue . '" ';
							break;
						default:
							$options .= 'value = "' . $optionValue . '">' . $optionValue . '</option>';		
					}
				}
			}
			return $options;
		}
	}
?>
