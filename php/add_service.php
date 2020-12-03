<?php
    require_once '../php/dynamic-queries/ConstructDBQueries.php';
    try {
        $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => 'PetHistory'));
        foreach($_POST as $postKey => $postValue) {
            $SQLConstruct = new SQL(json_decode($dbParams), json_decode($_POST[$postKey]));
            echo $SQLConstruct->constructQueryWithParams();
        }
    } catch (Throwable $e) {
        echo "Throwable Caught: " . $e;
    } catch (Throwable $ee) {
        echo "Exception caught: " . $ee;
    }

?>
