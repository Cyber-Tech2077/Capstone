
<?php
    require_once './dynamic-queries/ConstructDBQueries.php';
    try {
        $dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'insert', 'tableName' => 'PetHistory'));
        $dbTableColumns;
        foreach ($_POST as $postKey => $postValue) {
            $dbTableColumns = json_encode(json_decode($_POST[$postKey]));
        }
        $sqlConstruction = new SQL(json_decode($dbParams), json_decode($dbTableColumns));
        $sqlConstruction->constructQueryWithParams();
    } catch (Throwable $e) {
        echo "Throwable Caught: " . $e;
    } catch (Exception $ee) {
        echo "Exception Caught: " . $ee;
    }

?>

