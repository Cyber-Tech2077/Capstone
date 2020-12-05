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
		function getInfo(array $columns = array('*'), string $tableName = 'Pets', array $whereClause) {
			$dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'select', 'tableName' => $tableName));
			$retrieveValues = new SQL($dbParams, json_encode($columns), json_encode(array('where' => $whereClause)));
			echo $retrieveValues->constructSelectQueryAsArray();
		}
	}
	if (isset($_POST)) {
		$key1;
		$key2;
		foreach ($_POST as $postKey => $postValue) {
			$tableName;
			switch (strtoupper($postKey)) {
				case 'PETINFO':
					foreach (json_decode($postValue) as $petKey => $petValue) {
						if (is_array($petValue)) {
							$key1 = $petValue;
						} else {
							$key1 = array($petValue);
						}
					}
					$tableName = 'Pets';
					break;
				case 'LOCATIONINFO':
					foreach (json_decode($postValue) as $petKey => $petValue) {
						if (is_array($petValue)) {
							$key1 = $petValue;
						} else {
							$key1 = array($petValue);
						}
					}
					$tableName = 'Locations';
					break;
				case 'ADDITIONALINFO':
					foreach (json_decode($postValue) as $petKey => $petValue) {
						if (is_array($petValue)) {
							$key2 = $petValue;
						} else {
							$key2 = array($petValue);
						}
						$retrieveData = new DataRetrieval();
						$retrieveData->getInfo($key1, $tableName, array($petKey => $key2));
					}
					break;
			}
		}
	}
?>