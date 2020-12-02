<?php

    require_once "Constants.php";

    class SQLSettings {
        // Class variables in global scope
        private $columnKeys;
        private $columnParams;
        private $paramString;
        // POST variables
        private $querySettings;
	    private $queryColumns;
        private $queryParams;
        // Query parameter array values
        private $paramArrayValues = array();

        function setPostKeys(array $postArray) {
            $index = 0;
            foreach ($_POST as $postKey => $postValue) {
                switch ($index) {
                    case 0:
                        if (isset($postKey)) {
                            $this->querySettings = $_POST[$postKey];
                        }
                    break;
                    case 1:
                        if (isset($postKey)) {
                            $this->queryColumns = $_POST[$postKey];
                        }
                    break;
                    case 2:
                        if (isset($postKey)) {
                            $this->queryParams = $_POST[$postKey];
                        }
                    break;
                }
                $index++;
            }
        }
        function getQuerySettings() {
            return $this->querySettings;
        }
        function getQueryColumns() {
            return $this->queryColumns;
        }
        function getQueryParams() {
            return $this->queryParams;
        }
        function setColumns($columns, string $sqlType) {
            /**
            * Local scope
            * 
            *
            * Search the $columns array and assign an index to each item.
            */
            if (strtoupper($sqlType) !== Constants::SQL_DELETE) {
                if (is_object($columns)) {
                    $index = 0;
                    foreach ($columns as $key => $value):
                        if ($index < count(get_object_vars($columns)) - 1) {
                            if (strtoupper($sqlType) === Constants::SQL_UPDATE) {
                                $this->columnKeys .= $key . ' = ?, ';
                            } else {
                                $this->columnKeys .= $key . ', ';
                            }
                        } else {
                            if (strtoupper($sqlType) === Constants::SQL_UPDATE) {
                                $this->columnKeys .= $key . ' = ?';
                            } else {
                                $this->columnKeys .= $key;
                            }
                        }
                        $index++;
                    endforeach;
                } else {
                    foreach ($columns as $index => $value):
                        if ($index < count($columns) - 1) {
                            if (strtoupper($sqlType) === Constants::SQL_UPDATE) {
                                $this->columnKeys .= $value . ' = ?, ';
                            } else {
                                $this->columnKeys .= $value . ', ';
                            }
                        } else {
                            if (strtoupper($sqlType) === Constants::SQL_UPDATE) {
                                $this->columnKeys .= $value . ' = ?';
                            } else {
                                $this->columnKeys .= $value;
                            }
                        }
                    endforeach;
                }
            } else {
                $this->columnKeys .= '';
            }
        }
        // Output the string result.
        function getColumns() {
            return $this->columnKeys;
        }
        // Develop parameter strings for the insert statement.
        // Each column name represents a question mark parameter.
        function setColumnParams(object $columns, string $sqlType = Constants::SQL_INSERT) {
            if (strtoupper($sqlType) === Constants::SQL_INSERT):
                if (is_object($columns)) {
                    $index = 0;
                    foreach ($columns as $key => $value):
                        if ($index < count(get_object_vars($columns)) - 1):
                            $this->columnParams .= '?, ';
                        else:
                            $this->columnParams .= '?';
                        endif;
                        $index++;
                    endforeach;
                }
            endif;
        }
        function getColumnParams() {
            return $this->columnParams;
        }
        // Create SQL parameters assigned by columns in a params array.
        function setParamsString($params = NULL, string $sqlCondition) {
            if (isset($sqlCondition)) {
                if (strtoupper($sqlCondition) === Constants::SQL_WHERE) {
                    $this->paramString .= ' ' . $sqlCondition . ' ';
                    if (is_object($params)) {
                        $index = 0;
                        foreach ($params as $key => $value):
                            if ($index < count(get_object_vars($params)) - 1) {
                                $this->paramString .= $key . ' = ?, ';
                            } else {
                                $this->paramString .= $key . ' = ?';
                            }
                            $index++;
                        endforeach;
                    } else {
                        foreach ($params as $index => $key):
                            if ($index < count($params) - 1) {
                                $this->paramString .= key($key) . ' = ?, ';
                            } else {
                                $this->paramString .= key($key) . ' = ?';
                            }
                        endforeach;
                    }
                } else {
                    $condition;
                    if ($sqlCondition === Constants::SQL_GROUPBY) {
                        $condition = ' GROUP BY ';
                    } else if($sqlCondition === Constants::SQL_ORDERBY) {
                        $condition = ' ORDER BY ';
                    }
                        $this->paramString .= $condition;
                        foreach ($params as $key => $value):
                            $this->paramString .= $value;
                        endforeach;
                }
            }
        }
        function getParamsString() {
            return $this->paramString;
        }
        // This retrieves an object array that contains both key and value
        // pairs associated with the specific columns in an update statement.
        function setColumnParamValues(object $columns = NULL) {
            if (is_object($columns)) {
                foreach ($columns as $key => $value):
                    array_push($this->paramArrayValues, $value);
                endforeach;
            }
        }
        // Assign array with values in order with parameters.
        function setParamValues(array $params = NULL) {
            foreach ($params as $key => $value):
                array_push($this->paramArrayValues, $value);
            endforeach;
        }
        function getParamValues() {
            return $this->paramArrayValues;
        }
    }

?>