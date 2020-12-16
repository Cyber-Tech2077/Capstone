<?php
    require_once '../php/dynamic-queries/ConstructDBQueries.php';
    class SQLTypes {
        /**
         * This class is used to get query properties together so the queries can be constructed in ConstructDBQueries.
         * 
         * The function requirements for this class are:
         * 1) Column names either array or object array.
         * 2) Where clauses for update properties
         */

        /**
         * The post call requirements are:
         * 1) Json keys need to be either push, fetch or amend and need to be nesting data structures like so, fetch: {properties}.
         * 2) Data structures need property keys of the following:
         *      1) "items" for the columns. Also, columns can be constructed manually based on tablename.
         *      2) "whenever" for the where clauses
         * All others are options and this includes:
         *      1) "connect" for tablenames
         *      2) "fasten" for specific sql joins, these need to be constructed manually based on tablename.
         */
        private $columNames;
        private $tableName;
        private $whereClause;
        private $sqlKeyword;
        function __construct($columns = NULL, string $table = 'Pets', string $where = NULL, string $keyword = NULL) {
            $this->columNames = $columns;
            $this->tableName = $table;
            $this->whereClause = $where;
            $this->sqlKeyword = $keyword;
        }
        function insertTable() {
            try {
                if (isset($this->columNames)) {
                    $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => $this->tableName));
                    $SQLConstruct = new SQL($dbParams, json_encode(array('columnNames' => $this->columNames)));
                    echo $SQLConstruct->constructQueryWithParams();
                } else {
                    echo json_encode(array('error' => 'An error has occurred, please contact administrator.'));
                }
            } catch (Throwable $e) {
                echo "Throwable Caught: " . $e;
            } catch (Throwable $ee) {
                echo "Exception caught: " . $ee;
            }
        }
        function selectTable() {
            try {
                if (isset($this->columNames)) {
                    $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'select', 'tableName' => $this->tableName));
                    if (isset($this->whereClause)) {
                        $whereClauseString = json_encode(array('WHERE' => $this->whereClause));
                        if (isset($this->sqlKeyword)) {
                            $SQLConstruct = new SQL($dbParams, json_encode($this->columNames), $whereClauseString, $this->sqlKeyword);
                            echo $SQLConstruct->constructSelectQueryAsArray();
                        } else {
                            $SQLConstruct = new SQL($dbParams, json_encode($this->columNames), $whereClauseString);
                            echo $SQLConstruct->constructSelectQueryAsArray();
                        }
                    } else {
                        $SQLConstruct = new SQL($dbParams, json_encode($this->columNames));
                        echo $SQLConstruct->constructSelectQueryAsArray();
                    }
                } else {
                    echo json_encode(array('error' => 'An error has occurred, please contact administrator.'));
                }
            } catch (Throwable $e) {
                echo "Throwable Caught: " . $e;
            } catch (Throwable $ee) {
                echo "Exception caught: " . $ee;
            }
        }
        function updateTable() {
            try {
                if (isset($this->whereClause)) {
                    $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'update', 'tableName' => $this->tableName));
                    $whereClauseString = json_encode(array('WHERE' => $this->whereClause));
                    $SQLConstruct = new SQL($dbParams, $this->columNames, $whereClauseString);
                    echo $SQLConstruct->constructQueryWithParams();
                } else {
                    echo json_encode(array('error' => 'An error has occurred, please contact the administrator.'));
                }
            } catch (Throwable $e) {
                echo "Throwable Caught: " . $e;
            } catch (Throwable $ee) {
                echo "Exception caught: " . $ee; 
            }
        }
    }
    // Javascript code is available to the user, using a post call that references sql queries could give a hacker a hint.
    // Using a different method could *potentially* (not guaranteed) throw off a hacker. Therefore, non referencable words are being used for sql properties.
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
                                    case 'LOCATION':
                                        $tableName = 'Locations';
                                        break;
                                    case 'HISTORY':
                                        $tableName = 'PetHistory';
                                        break;
                                    default:
                                        $tableName = $tableValue;
                                }
                            }
                            break;
                    }
                }
                $insert;
                if (isset($tableName)) {
                    $insert = new SQLTypes($tableColumns, $tableName);
                } else {
                    $insert = new SQLTypes($tableColumns);
                }
                $insert->insertTable();
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
                                            $columns = array('PetHistory.date', 'PetHistory.serviceName', 'Locations.business', 'PetHistory.vetted', 'PetHistory.grooming', 'PetHistory.boarding', 'PetHistory.details');
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
                                        $tableName = 'Locations';
                                        break;
                                    case 'HISTORY':
                                        $tableName = 'PetHistory';
                                        break;
                                    default:
                                        $tableName = $tableValue;
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
                $select;
                if (isset($tableName) && isset($whereClause) && isset($sqlKeyword) ) {
                    $select = new SQLTypes($columns, $tableName, $whereClause, $sqlKeyword);
                } else {
                    if (isset($tableName) && isset($whereClause)) {
                        $select = new SQLTypes($columns, $tableName, $whereClause);
                    } else {
                        if (isset($tableName)) {
                            $select = new SQLTypes($columns, $tableName);
                        } else {
                            $select = new SQLTypes($columns, 'Pets');
                        }
                    }
                }
                $select->selectTable();
                break;
            case 'AMEND':
                foreach ($postValue as $objectKeys => $objectValues) {
                    $columns;
                    $tableName;
                    $whereClause;
                    switch (strtoupper($objectKeys)) {
                        case 'ITEMS':
                            $columns = $objectValues;
                            break;
                        case 'CONNECT':
                            foreach (json_decode($objectValues) as $tableKey => $tableValue) {
                                switch (strtoupper($tableValue)) {
                                    case 'LOCATION':
                                        $tableName = 'Locations';
                                        break;
                                    default:
                                        $tableName = $tableValue;
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
                $update;
                if (isset($tableName)) {
                    $update = new SQLTypes($columns, $tableName, $whereClause);
                } else {
                    $update = new SQLTypes($columns, 'Pets', $whereClause);
                }
                $update->updateTable();
                break;
        }
    }
?>
