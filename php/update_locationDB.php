
  
<?php
	require_once "./dynamic-queries/ConstructDBQueries.php";

	try{

		$dbParams = json_encode(array('dbName' => 'Pet', 'sqlType' => 'update', 'tableName' => 'Locations'));
		$dbColumnNames;
		$dbWhereClause;
		foreach ($_POST as $postKey => $postValue) {
			switch ($postKey) {
				case 'updateLocation':
					$dbColumnNames = json_encode(array('columns' => json_decode($_POST[$postKey])));
					break;
				case 'updateTo':
					$dbWhereClause = json_encode(array('where' => json_decode($_POST[$postKey])));
					break;
			}
		}
		$updateLocation = new SQL(json_decode($dbParams), json_decode($dbColumnNames), json_decode($dbWhereClause));
		echo $updateLocation->constructQueryWithParams();
		
	} catch (Throwable $e){
		echo "Throwable error " . $e;
	}
?>