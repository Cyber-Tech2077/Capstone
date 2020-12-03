<?php
    require_once '../dynamic-queries/ConstructDBQueries.php';
    try {

        $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => 'users'));
        $dbColumnNames;
        foreach ($_POST as $postKey => $postValue) {
            $dbColumnNames = json_encode(array($_POST[$postKey]));
        }
        $userCredentials = new SQL(json_encode($dbParams), json_decode($dbColumnNames));
        $userCredentials->constructSelectQueryAsObject();
    } catch (Exception $e) {
        return 'Exception: ' . $e;
    } catch (Throwable $ee) {
        return 'Throwable: ' . $ee;
    }

?>