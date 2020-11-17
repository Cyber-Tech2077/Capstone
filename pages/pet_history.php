<?php
	
	include ("../php/headernav.html");
	require_once "../php/DBConnect.php";

	//Drop Down Selector for the Pets
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
<html lang="en">
<head>
  <title>Team Purple B03</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <style href="../css/bootstrap.min" rel="stylesheet" type="text/css"></style>
  <script src="../js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">	
</head>

<script type="text/javascript">

	$(document).ready(function() {

		$("#selectHistory").click(function() {

			var petChosen = document.getElementById("select_pet_control");

			//alert(pet);

			$.post({
				url: "../php/petHistoryDB.php",
				data: { pet_id: petChosen.options[petChosen.selectedIndex].id },
				success: function(feedback) {
					
					//Read entries pulled
					var json = JSON.parse(feedback);

					//get amount of rows to print
					var entriesTotal = (Object.keys(json)).length;
					var rowsTotal =  entriesTotal/3;		//divided by 3, the amount of columns, may increase later

					//make sure table is clear
					$("#output_body tr").remove(); 

					//loop through array to make new row for each service with date
					var tbodyRef = document.getElementById('output_body');

					for(var row = 0; row < rowsTotal; row++) {
						var newRow = tbodyRef.insertRow(row);

						var cell1 = newRow.insertCell(0);
						var cell2 = newRow.insertCell(1);
						var cell3 = newRow.insertCell(2);

						cell1.innerHTML = json["Date" + row];
						cell2.innerHTML = json["Service" + row];

						cell3.id = "loc" + row;
						GetLocationName(json["Location" + row], row);
					}

				},
				error: function(err) {
					alert("Err " + err);
				}
			});

		});

	});

	function GetLocationName(locationId, row) {
		$.post({
			url: "../php/pet_history_get_locationDB.php",
			data: { id : locationId },
			success: function(feedback){
				var json = JSON.parse(feedback);
				var cell = document.getElementById("loc" + row);
				cell.innerHTML = json["Location"];
			},
			error: function(err) {
				alert("Err " + err);
			}
		});
	}

</script>

<body>
 
<div class="jumbotron jumbotron-sm">
  <div class="container">
      <div class="row">
          <div class="col-sm-12 col-lg-12">
              <h1 class="h1">Pet History</h1>
          </div>
      </div>
  </div>
</div>

<div class="form-group col-8">
	<legend class="control-legend" id="select_pet">Select Pet</legend>
	<select class="form-control" id="select_pet_control">

		<!-- Select Pet Dropdown Options - Goes Here -->
		<option value=""></option>
		<?php comboboxOptions(); ?>

	</select>					
</div>

<div class="form-group text-center">
	<button type="submit" class="btn btn-primary" id="selectHistory">Submit</button>
</div>

<div class="container">
<table class="table" id="outputHistory">
	<thead>
		<tr>
			<th scrop="col">Date</th>
			<th scope="col">Service</th>
			<th scope="col">Location</th>
		</tr>
	</thead>
	<tbody id="output_body">
		<!-- Loop through each entry here -->
	</tbody>
</table>
</div>

</body>
</html>