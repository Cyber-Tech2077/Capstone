<?php

    require_once ("./dynamic-queries/ConstructDBQueries.php");
    
    try{

        $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'select', 'tableName' => 'Locations'));
        $dbColumnNames = json_encode(array('business', 'address', 'city', 'state', 'zip', 'email', 'phoneNumber', 'veterinary', 'groom', 'board'));
        foreach ($_POST as $postKey => $postValue) {
            $dbWhereClause = json_encode(array('where' => json_decode($_POST[$postKey])));
        }
        $retrieveLocation = new SQL($dbParams, $dbColumnNames, $dbWhereClause);
        echo $retrieveLocation->constructSelectQueryAsObject();

    } catch (Throwable $e){	
        return "Throwable error " . $e;
    }

?>
