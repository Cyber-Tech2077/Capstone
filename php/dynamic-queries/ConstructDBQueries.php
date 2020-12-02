<?php
	if (strpos(getcwd(), 'pages')) {
		require_once "../php/dynamic-queries/DBConnect.php";
		require_once "../php/dynamic-queries/classes/Constants.php";
		require_once "../php/dynamic-queries/classes/Settings.php";
	} else {
		require_once "./dynamic-queries/DBConnect.php";
		require_once "./dynamic-queries/classes/Constants.php";
		require_once "./dynamic-queries/classes/Settings.php";
	}

	/**
	 * The entire process of this file is to automate the construction of sql queries without having to
	 * manually type them. All sqlsrv syntax is written out in each of the class methods to process the query string.
	 * Any errors that show up during the process will be echoed out in json format.
	 */
	class SQL extends SQLSettings {
		// Global variables
		private $dbParams;
		private $dbConn;
		/** 
		 * These three parameters reference to the type of sql statements being used.
		 * 1) dbParams references the dbName, sqlType and the tableName.
		 * 2) dbTableColumnNames references the columnNames and values in json. {arrayName: {columnName: value}}
		 * 3) dbQueryParams references the query params associated with the sql statement being used. {where: {columnName: value}, groupby: columnName}
		 */
		function __construct($dbParams, $dbTableColumnNames = NULL, $dbQueryParams = NULL, $dbSQLKeywords = NULL) {
			if (isset($dbParams)) {

				$index = 0;
				
				foreach ($dbParams as $key => $value) {
					switch ($index) {
						case 0:
							// Retrieve db name and build connection string
							$this->dbConn = databaseConnect($value);
						break;
						case 1:
							if (isset($dbTableColumnNames)) {
								if (is_array($dbTableColumnNames)) {
									SQLSettings::setColumns($dbTableColumnNames, $dbParams->$key);
								} else {
									foreach ($dbTableColumnNames as $jsonKey => $jsonValues) {
										if (isset($jsonValues)) {
											SQLSettings::setColumns((object) $jsonValues, $dbParams->$key);
											SQLSettings::setColumnParams((object) $jsonValues, $dbParams->$key);
											SQLSettings::setColumnParamValues((object) $jsonValues);											
										}
									}
								}
							}
						break;
						case 2:
							SQLSettings::setTableNames($value);
						break;
					}
					$index++;
				}
				// Assign dbParams to global variable using $this keyword.
				$this->dbParams = $dbParams;
			}
			if (isset($dbQueryParams)) {
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
			if (isset($dbSQLKeywords)) {
				foreach ($dbSQLKeywords as $sqlKeyWord => $sqlKeyWordValue) {
					foreach ($sqlKeyWordValue as $key => $value) {
						SQLSettings::setSQLKeywords($sqlKeyWord, $key, $value);
					}
				}
			}
		}
		/** 
		 * 1) This dynamically builds queries based on json information given to the class constructor.
		 * 2) This method doesn't construct select statements. Only insert, update and delete statements. Use constructSelectQuery() instead.
		*/
		function constructQueryWithParams() {
			try {
				/**
				 * Steps to create sql statement:
				 * 1) Determine sqlType and assign the sql keyword to the $createStmt variable.
				 * 2) Construct sql query with sqlType syntax like 'INTO' or 'SET' and pass database info into the SQLSettings class.
				 * 3) Retrieve the output from SQLSettings and pass them into sql statement.
				 * 4) Complete sql query and pass SQLSettings result parameter values into sql server prepare statement as an argument.
				 * 5) Execute the prepare statement and get the results in json format back to the web browser. Note: sqlsrv errors will not show up in web browser for security reasons.
				 */
				$createStmt = '';
				if (isset($this->dbParams->sqlType)) {
					$createStmt = strtoupper($this->dbParams->sqlType);
				} else {
					$createStmt = 'INSERT ';
				}
				// Use the switch statement to determine what sqlType the query is. If no sqlType is specified,
				// then the query by default will be made into a insert statement.
				switch (strtoupper($this->dbParams->sqlType)) {
					case Constants::SQL_UPDATE:
						$createStmt .= SQLSettings::getTableNames() . ' SET ';
						$createStmt .= SQLSettings::getColumns() . SQLSettings::getParamsString();
						break;
					case Constants::SQL_DELETE:
						$createStmt .= ' FROM ' . SQLSettings::getTableNames() . SQLSettings::getParamsString();
						break;
					default:
						$createStmt .= ' INTO ' . SQLSettings::getTableNames() . ' (';
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
		/** 
		 * This method dynamically builds select queries based on json information given to the class constructor.
		 * This method doesn't construct insert, update or delete sql statements. Use constructQueryWithParams() instead.
		*/
		function constructSelectQueryAsArray() {
			try {
				$createStmt = $this->dbParams->sqlType . ' ';
				$createStmt .= SQLSettings::getColumns();
				$createStmt .= " FROM " . SQLSettings::getTableNames();
				$createStmt .= SQLSettings::getSQLKeywords();
				$createStmt .= SQLSettings::getParamsString();

				$stmt = sqlsrv_prepare($this->dbConn, $createStmt, SQLSettings::getParamValues());
				$execute = sqlsrv_execute($stmt);
				$jsonResult;
				if ($execute) {
					$jsonResult = "[";
					$counter;
					$overallCounter = 0;
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
									if ($counter !== count($row) - 1) {
										$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"' . ", ";
									} else {
										$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"';
									}
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
		/** 
		 * This method dynamically builds select queries based on json information given to the class constructor.
		 * This method doesn't construct insert, update or delete sql statements. Use constructQueryWithParams() instead.
		*/
		function constructSelectQueryAsObject() {
			try {
				$createStmt = $this->dbParams->sqlType . ' ';
				$createStmt .= SQLSettings::getColumns();
				$createStmt .= " FROM " . SQLSettings::getTableNames();
				$createStmt .= SQLSettings::getSQLKeywords();
				$createStmt .= SQLSettings::getParamsString();

				$stmt = sqlsrv_prepare($this->dbConn, $createStmt, SQLSettings::getParamValues());
				$execute = sqlsrv_execute($stmt);
				$jsonResult;
				if ($execute) {
					$counter;
					$overallCounter = 0;
					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
						$counter = 0;
						if (!isset($jsonResult)) {
							$jsonResult = "{";
						} else {
							$jsonResult .= ", {";
						}
						foreach ($row as $name => $values) {
							if ($counter !== count($row) - 1) {
								if (sqlsrv_field_metadata($stmt)[$counter]["Type"] === 91) {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"' . ", ";
								} else {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . strval($values) . '"' . ", ";
								}
							} else {
								if (sqlsrv_field_metadata($stmt)[$counter]["Type"] === 91) {
									if ($counter !== count($row) - 1) {
										$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"' . ", ";
									} else {
										$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . date_format($values, "Y-m-d") . '"';
									}
								} else {
									$jsonResult .= '"' . sqlsrv_field_metadata($stmt)[$counter]["Name"] . '"' . ': "' . strval($values) . '"';
								}
							}
							$counter += 1;
						}
						$jsonResult .= "}";
						$overallCounter += 1;
					}
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
?>