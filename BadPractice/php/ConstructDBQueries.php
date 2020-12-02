<?php
	require_once "./DBConnect.php";
	require_once "./classes/Constants.php";
	require_once "./classes/Settings.php";

	class SQL extends SQLSettings {
		// Declare the database connection variable
		private $dbParams;
		private $dbConn;
		// Constructor arguments that have a specified required type and has a default value if nothing is assigned. For example, $columnNameArray = NULL.
		function __construct($dbParams = NULL, $dbTableColumnNames = NULL,$dbQueryParams = NULL) {
			// Assign global variables to constructor parameter values. If certain parameters are not assigned values, skip using the assignment operator.
			if (isset($dbParams)) {
				$this->dbParams = $dbParams;
			}
			if (isset($dbParams->dbName)) {
				$this->dbConn = databaseConnect($dbParams->dbName);
			}
			if (isset($dbTableColumnNames)) {
				foreach ($dbTableColumnNames as $jsonKey => $jsonValues) {
					if (isset($jsonValues)) {
						if (is_array($jsonValues)) {
							SQLSettings::setColumns($jsonValues, $dbParams->sqlType);
						} else {
							SQLSettings::setColumns((object) $jsonValues, $dbParams->sqlType);
							SQLSettings::setColumnParams((object) $jsonValues, $dbParams->sqlType);
							SQLSettings::setColumnParamValues((object) $jsonValues);
						}
					}
				}
			}
			if (isset($dbQueryParams)) {
				// Determine if a condition is specified. If not, assume and make the condition a where clause
				// if the params array has values.
				foreach ($dbQueryParams as $objectKey => $objectValue) {
					$index = 0;
					if (is_array($dbQueryParams->$objectKey)) {
						SQLSettings::setParamsString($dbQueryParams->$objectKey, strtoupper($objectKey));
					} else {
						SQLSettings::setParamsString((object) $dbQueryParams->$objectKey, strtoupper($objectKey));
					}
					$index++;
					if (strtoupper($objectKey) === Constants::SQL_WHERE){
						SQLSettings::setParamValues(get_object_vars((object) $objectValue));
					}
				}
			}
		}
		// Using a prebuilt query, retrieve values that are specified in the columnNameArray variable.
		// Prebuilt query like "SELECT * FROM COLUMN_NAME"
		function prebuiltQueryNoParams() {
			if (isset($this->dbParams->sqlQuery)) {
				try {
					$stmt = sqlsrv_query($this->dbConn, $this->dbParams->sqlQuery);
					if ($stmt) {
						$rowValues = array();
						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
							for ($i = 0; $i < count($row); $i++) {
								array_push($rowValues, $row[$i]);
							}
							// To reduce result output, exit out of the sqlsrv array
							// when the foreach loop is done cycling.
							break;
						}
						sqlsrv_close($this->dbConn);
						return json_encode($rowValues);
					} else {
						return "SQL Server Error: " . sqlsrv_errors();
					}
				} catch (Throwable $e) {
					return "Throwable Error Caught: " . $e;
				}
			} else {
				return json_encode(array("Null" => "Query"));
			}
		}
		function constructQueryWithParamsWhereCondition() {
			try {
				// Local variables
				$createStmt = strtoupper($this->dbParams->sqlType) . ' ';
				// Use the switch statement to determine what sqlType the query is. If no sqlType is specified,
				// then the query by default will be made into a select statement.
				switch (strtoupper($this->dbParams->sqlType)) {
					case Constants::SQL_UPDATE:
						$createStmt .= $this->dbParams->tableName . ' SET ';
						$createStmt .= SQLSettings::getColumns() . SQLSettings::getParamsString();
						break;
					case Constants::SQL_DELETE:
						$createStmt .= ' FROM ' . $this->dbParams->tableName . SQLSettings::getParamsString();
						break;
					default:
						$createStmt .= ' INTO ' . $this->dbParams->tableName . ' (';
						$createStmt .= SQLSettings::getColumns();
						$createStmt .= ') VALUES (';
						$createStmt .= SQLSettings::getColumnParams();
						$createStmt .= ')';
				}
				$stmt = sqlsrv_prepare($this->dbConn, $createStmt, SQLSettings::getParamValues());
				$execute = sqlsrv_execute($stmt);
				if ($execute) {
					echo json_encode('{' . '"successful":' . '"' . $this->dbParams->sqlType . ' successful!' . '"' . '}');
				} else {
					$errorText = '{';
					foreach (sqlsrv_errors() as $errorKey => $errorValue) {
						$index = 0;
						foreach ($errorValue as $key => $value) {
							if ($index < count($errorValue) - 1) {
								$errorText .= '"' . $key . '": "' . $value . '",';
							} else {
								$errorText .= '"' . $key . '": "' . $value . '"';
							}
							$index++;
						}
						break;
					}
					$errorText .= '}';
					echo json_encode($errorText);
				}
				sqlsrv_close($this->dbConn);
			} catch (Throwable $e) {
				return 'Throwable Exception Error: ' . $e;
			}
		}
		function constructSelectQuery() {
			try {
				$createStmt = $this->dbParams->sqlType . ' ';
				$createStmt .= SQLSettings::getColumns();
				$createStmt .= " FROM " . $this->dbParams->tableName;
				$createStmt .= SQLSettings::getParamsString();

				$stmt = sqlsrv_prepare($this->dbConn, $createStmt, SQLSettings::getParamValues());
				// Execute the query with params and assign a boolean to the 'execute' variable.
				$execute = sqlsrv_execute($stmt);
				$jsonResult;
				if ($execute) {
					$jsonResult = "[";
					$counter;
					$overallCounter = 0;
					// Fetch the arrays associated with each row with the specified columns in the select statement.
					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
						$counter = 0;
						if ($jsonResult !== "[") {
							$jsonResult .= ", ";
						}
						$jsonResult .= "{";
						foreach ($row as $name => $values) {
							if ($counter !== count($row) - 1) {
								if (sqlsrv_field_metadata($stmt)[$counter]["Type"] === 91) {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"' . ", ";
								} else {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . strval($values) . '"' . ", ";
								}
							} else {
								if (sqlsrv_field_metadata($stmt)[$counter]["Type"] === 91) {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"' . ", ";
								} else {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . strval($values) . '"';
								}
							}
							$counter += 1;
						}
						$jsonResult .= "}";
						$overallCounter += 1;
					}
					$jsonResult .= "]";
				} else {
					foreach (sqlsrv_errors() as $errorKey => $errorValue) {
						foreach ($errorValue as $key => $value) {
							if ($key === 'message') {
								$jsonResult = '{"' . 'Error' . '"' . ': "' . $value . '"}';
							}
						}
						break;
					}
				}
				echo json_encode($jsonResult);
			} catch (Throwable $e) {
				return "Throwable Error: " . $e;
			}
		}
	}
	$settings = new SQLSettings();
	$settings->setPostKeys($_POST);
	if ($settings->getQuerySettings() !== NULL && $settings->getQueryColumns() !== NULL && $settings->getQueryParams() === NULL) {
		$SQL = new SQL(json_decode($settings->getQuerySettings()), json_decode($settings->getQueryColumns()));
	} else if ($settings->getQuerySettings() !== NULL && $settings->getQueryColumns() !== NULL && $settings->getQueryParams() !== NULL) {
		$SQL = new SQL(json_decode($settings->getQuerySettings()), json_decode($settings->getQueryColumns()), json_decode($settings->getQueryParams()));
	}

	$dbParams = json_decode($settings->getQuerySettings());
	// Construct query or use prebuilt query by user with no params.
	if (isset($dbParams->sqlQuery)) {
		$SQL->prebuiltQueryNoParams($dbParams->sqlQuery);
	} else {
		switch (strtoupper($dbParams->sqlType)) {
			case Constants::SQL_SELECT:
				$SQL->constructSelectQuery();
				break;
			default:
				$SQL->constructQueryWithParamsWhereCondition();
		}
	}
?>