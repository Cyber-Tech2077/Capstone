<?php
    require_once './dynamic-queries/ConstructDBQueries.php';
    try {
        
        $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => 'Locations'));
        foreach ($_POST as $postKey => $postValue) {
            $SQLConstruct = new SQL(json_decode($dbParams), json_decode($_POST[$postKey]));
            $SQLConstruct->constructQueryWithParams();
        }
    } catch (Throwable $e) {
        echo "Throwable Caught: " . $e;
    } catch (Exception $ee) {
        echo "Exception Caught: " . $ee;
    }
?>