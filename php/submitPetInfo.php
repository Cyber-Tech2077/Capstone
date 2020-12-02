<?php
require_once "./dynamic-queries/ConstructDBQueries.php";

try {
    /**
     * For the SQL class to work, you must order the arguments as follows:
     * 1) Database name
     * 2) SQL type
     * 3) Database table name
     * Note: The names of the keys like 'dbName', don't have to be named that. The name of the keys can be whatever you like.
     */
    $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => 'Pets'));
    $SQLConstruct = new SQL(json_decode($dbParams), json_decode($_POST['pet']));
    $SQLConstruct->constructQueryWithParams();

} catch (Throwable $e) {
    echo "Throwable Caught: " . $e;
} catch (Exception $ee) {
    echo "Exception Caught: " . $ee;
}