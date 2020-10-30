<?php
    session_start();
    include ("../php/headernav.html");
    include_once("../php/DBConnect.php");

    //Pet Selector
	function comboboxOptions() {
		$conn = databaseConnect("Pet");
		try {
			$sql = "select id, name from Pets";
			$stmt = sqlsrv_query($conn, $sql);
			if ($stmt === false) {
				echo "Error Occurred: " . sqlsrv_errors();
			} else {
				$storeValueId;
				while ($row = sqlsrv_fetch_object($stmt)) {
					echo "<option id = " . $row->id . " value = " . $row->name . ">" . $row->name . "</option>";
				}
			}
		} catch (Throwable $e) {
			echo "Throwable Error: " . $e;
		}
        sqlsrv_close($conn);

    }
        
?>
<!DOCTYPE html>
<html>

    <title>Team Purple B03</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">

<head>
</head>
<body>

    <div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">FORM NAME - CHANGE THIS</h1>
            </div>
        </div>
    </div>
    </div>

    <div class="form-group col-8">
	<legend class="control-legend" id="select_pet">Select Pet</legend>
        <select class="form-control" id="select_pet">

            <!-- Select Pet Dropdown Options -->
            <?php comboboxOptions(); ?>

        </select>					
    </div>

    <form>
        <div class="form-group col-sm-10">
            <legend class="control-legend">Select Date for _[Fill in type]_ Service:</legend>
        </div>
    
        <!-- Birth Date -->
        <div class="form-group col-sm-10">
            <label class="control-label">Service Date:</label>
            <input class="form-control col-8" type="date" id="service_date_id" name="service_date">
        </div>

    </form>

    <!-- Save Button -->
    <div class="form-group text-center">
        <button class="btn btn-primary" id="save_service">Save</button>
    </div>

</body>
</html>