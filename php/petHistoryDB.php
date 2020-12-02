
<?php

require_once './dynamic-queries/ConstructDBQueries.php';

try {
    /**
     * For the SQL class to work, you must order the arguments as follows:
     * 1) Database name
     * 2) SQL type
     * 3) Database table name
     * Note: The names of the keys like 'dbName', don't have to be named that. The name of the keys can be whatever you like.
     */
    $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'select', 'tableName' => 'PetHistory'));
    $dbTableColumns = json_encode(array('PetHistory.serviceDate', 'PetHistory.serviceName', 'Locations.business', 'PetHistory.nailsClipped', 'PetHistory.grooming', 'PetHistory.boarding', 'PetHistory.serviceDetails'));
    $dbInnerJoin = json_encode(array('innerjoin' => array('Locations' => ['PetHistory.locationId', 'Locations.id'])));
    foreach ($_POST as $postKey => $postValue) {
        $dbWhereClause = json_encode(array('where' => json_decode($_POST[$postKey])));
    }
    $SQLConstruct = new SQL(json_decode($dbParams), json_decode($dbTableColumns), json_decode($dbWhereClause), json_decode($dbInnerJoin));
    $SQLConstruct->constructSelectQueryAsArray();
} catch (Throwable $e) {
    echo "Throwable Caught: " . $e;
} catch (Exception $ee) {
    echo "Exception Caught: " . $ee;
}