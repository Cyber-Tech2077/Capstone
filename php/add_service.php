<?php
    require_once '../php/dynamic-queries/ConstructDBQueries.php';
    class SQLTypes {
        function insertTable($columNames = NULL, string $tableName = 'Pets') {
            try {
                $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => $tableName));
                $SQLConstruct = new SQL($dbParams, json_encode(array('columnNames' => $columNames)));
                echo $SQLConstruct->constructQueryWithParams();
            } catch (Throwable $e) {
                echo "Throwable Caught: " . $e;
            } catch (Throwable $ee) {
                echo "Exception caught: " . $ee;
            }
        }
        function selectTable($columNames = NULL, string $tableName = 'Pets', string $whereClause = NULL, string $sqlKeywords = NULL) {
            try {
                $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'select', 'tableName' => $tableName));
                $whereClauseString = json_encode(array('WHERE' => $whereClause));
                if (isset($sqlKeywords)) {
                    $SQLConstruct = new SQL($dbParams, json_encode($columNames), $whereClauseString, $sqlKeywords);
                    echo $SQLConstruct->constructSelectQueryAsArray();
                } else {
                    $SQLConstruct = new SQL($dbParams, json_encode($columNames), $whereClauseString);
                    echo $SQLConstruct->constructSelectQueryAsArray();
                }
            } catch (Throwable $e) {
                echo "Throwable Caught: " . $e;
            } catch (Throwable $ee) {
                echo "Exception caught: " . $ee;
            }
        }
        function updateTable(string $columNames = NULL, string $tableName = 'Pets', string $whereClause = NULL) {
            try {
                $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'update', 'tableName' => $tableName));
                $whereClauseString = json_encode(array('WHERE' => $whereClause));
                $SQLConstruct = new SQL($dbParams, $columNames, $whereClauseString);
                echo $SQLConstruct->constructQueryWithParams();
            } catch (Throwable $e) {
                echo "Throwable Caught: " . $e;
            } catch (Throwable $ee) {
                echo "Exception caught: " . $ee;
            }
        }
    }
    // Javascript code is available to the user, using a post call that references sql queries could give a hacker a hint.
    // Using a different method could throw off a hacker. Therefore, non referencable words are being used for sql queries.
    foreach($_POST as $postKey => $postValue) {
        switch (strtoupper($postKey)) {
            case 'PUSH':
                foreach ($postValue as $columnKey => $columnValue) {
                    $tableColumns;
                    $tableName;
                    switch (strtoupper($columnKey)) {
                        case 'ITEMS':
                            $tableColumns = json_decode($columnValue);
                            break;
                        case 'CONNECT':
                            foreach ($postValue as $tableKey => $tableValue) {
                                switch (strtoupper($tableValue)) {
                                    case 'HISTORY':
                                        $tableName = 'PetHistory';
                                        break;
                                }
                            }
                            break;
                    }
                }
                $insert = new SQLTypes();
                if (isset($tableName)) {
                    $insert->insertTable($tableColumns, $tableName);
                } else {
                    $insert->insertTable($tableColumns);
                }
            break;
            case 'FETCH':
                foreach ($postValue as $objectKeys => $objectValues) {
                    $columns;
                    $tableName;
                    $whereClause;
                    $sqlKeyword;
                    switch (strtoupper($objectKeys)) {
                        case 'ITEMS':
                            foreach (json_decode($objectValues) as $columnKeys => $columnValues) {
                                if (!is_array($columnValues)) {
                                    switch (strtoupper($columnValues)) {
                                        case 'HISTORY':
                                            // This is a prefab for an inner join.
                                            $columns = array('PetHistory.serviceDate', 'PetHistory.serviceName', 'Locations.business', 'PetHistory.vetted', 'PetHistory.grooming', 'PetHistory.boarding', 'PetHistory.serviceDetails');
                                            break;
                                    }
                                } else {
                                    $columns = $columnValues;
                                }
                            }
                            break;
                        case 'CONNECT':
                            foreach (json_decode($objectValues) as $tableKey => $tableValue) {
                                switch (strtoupper($tableValue)) {
                                    case 'LOCATION':
                                        $tableName = 'locations';
                                        break;
                                    case 'HISTORY':
                                        $tableName = 'PetHistory';
                                        break;
                                }
                            }
                            break;
                        case 'FASTEN':
                            foreach (json_decode($objectValues) as $tableKey => $tableValue) {
                                switch (strtoupper($tableValue)) {
                                    case 'LOCATION':
                                        $sqlKeyword = json_encode(array('innerjoin' => array('Locations' => ['PetHistory.locationId', 'Locations.id'])));
                                        break;
                                }
                            }
                        break;
                        case 'WHENEVER':
                            foreach (json_decode($objectValues) as $whereKeys => $whereValues) {
                                $whereClause = json_encode(array($whereKeys => $whereValues));
                            }
                            break;
                    }
                }
                $select = new SQLTypes();
                if (isset($tableName) && isset($sqlKeyword)) {
                    $select->selectTable($columns, $tableName, $whereClause, $sqlKeyword);
                } else {
                    if (isset($tableName)) {
                        $select->selectTable($columns, $tableName, $whereClause);
                    } else {
                        if (isset($sqlKeyword)) {
                            $select->selectTable($columns, 'Pets', $whereClause, $sqlKeyword);
                        } else {
                            $select->selectTable($columns, 'Pets', $whereClause);
                        }
                    }
                }
                break;
            case 'AMEND':
                foreach ($postValue as $objectKeys => $objectValues) {
                    $columns;
                    $whereClause;
                    switch (strtoupper($objectKeys)) {
                        case 'ITEMS':
                            foreach (json_decode($objectValues) as $columnKey => $columnValue) {
                                $columns = json_encode(array('items' => $columnValue));
                            }
                            break;
                        case 'WHENEVER':
                            foreach (json_decode($objectValues) as $whereKeys => $whereValues) {
                                foreach ($whereValues as $key => $value) {
                                    $whereClause = json_encode(array($key => $value));
                                }
                            }
                            break;
                    }
                }
                $update = new SQLTypes();
                $update->updateTable($columns, 'Pets', $whereClause);
                break;
        }
    }
?>
