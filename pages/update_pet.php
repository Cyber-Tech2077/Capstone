<?php
	//session_start();
	include (__DIR__ . "/../php/headernav.html");
	include_once(__DIR__."/../php/DBConnect.php");
	function comboboxOptions() {
		// This php code works, all values come out as normal.
		// No need to mess with this.
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
  
  <style href="../css/bootstrap.min" rel="stylesheet" type="text/css"></style>
  <script src="../js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">	
</head>

<script type="text/javascript">

	$(document).ready(function() {
		var idNum = document.getElementById("select_pet_control");
		$("#select_pet_control").change(function(){
			$.post({
				url: "../php/retrieve_pet.php",
				data: {pet_ID: idNum.options[idNum.selectedIndex].id},
				success: function(feedback){
					var json = JSON.parse(feedback);
					document.getElementById("petname_id").value = json["Name"];
					if (json["Species"]=="Dog"){
						document.getElementById("speciesRadios1").checked = true;
					} else {
						document.getElementById("speciesRadios2").checked = true;
					}

					document.getElementById("weight_id").value = json["Weight"];
					document.getElementById("street_id").value = json["Street"];
					document.getElementById("city_id").value = json["City"];
					document.getElementById("state_id").value = json["State"];
					document.getElementById("zip_id").value = json["Zip"];
					document.getElementById("chip_id").value = json["Chip"];				
				}
				
			});
		});
		
		$("#update_pet").click(function() {
			// Changed id assocaited with select html element.
			var petSpecies;
			if (document.getElementById("speciesRadios1").checked) {
				petSpecies = "Dog";
			} else {
				petSpecies = "Cat";
			}
			// Used idNum.options[idNum.selectedIndex].id to fetch the id associated with the
			// selected pet name.


			$.post({
				url: "../php/update_petDB.php",
				data: {	pet_name: document.getElementById("petname_id").value, 
						pet_species: petSpecies, 
						pet_birthdate: document.getElementById("birthday_id").value, 
						pet_weight: document.getElementById("weight_id").value,
						pet_street: document.getElementById("street_id").value, 
						pet_city: document.getElementById("city_id").value,
						pet_state: document.getElementById("state_id").value, 
						pet_zip: document.getElementById("zip_id").value, 
						pet_chip: document.getElementById("chip_id").value, 
						pet_ID: idNum.options[idNum.selectedIndex].id
				}, 
				success: function() {
					location.reload();
					alert("Update saved");
				}
			});
		});
	});


</script>


<body>
 
<div class="jumbotron jumbotron-sm">
  <div class="container">
      <div class="row">
          <div class="col-sm-12 col-lg-12">
              <h1 class="h1">Update Pet</h1>
          </div>
      </div>
  </div>
</div>

<div class="form-group col-8">
	<legend class="control-legend" id="select_pet">Select Pet</legend>
	<select class="form-control" id="select_pet_control" >

		<!-- Select Pet Dropdown Options - Goes Here -->
		<option value=""></option>
		<?php comboboxOptions(); ?>

	</select>					
</div>

<form>
<!-- Name -->
	<div class="form-group col-sm-10">
 		<label class="control-label">Name</label>
 		<input type="text" class="form-control col-8" id="petname_id" name="petname">
 	</div>

<!-- Species -->
	<div class="form-group col-sm-10">
		<label class="col-form-label">Species</label>
	    <div class="form-check">
			<label class="form-check-label">
			<input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios1" value="dog" checked>Dog</label>
  		</div>
    	<div class="form-check">
    		<label class="form-check-label">
    		<input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios2" value="cat">Cat</label>
    	</div>
  	</div>

<!-- Birth Date -->
	<div class="form-group col-sm-10">
  		<label class="control-label">Birth Date</label>
  		<input class="form-control col-8" type="date" id="birthday_id" name="birthday">
	</div>

<!-- Weight -->
	<div class="form-group col-sm-10">
		<label class="col-form-label">Weight in lbs.</label>
		<input class="form-control" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0">
	</div>

<!-- chipId -->
	<div class="form-group col-sm-10">
 		<label class="control-label">Chip ID</label>
 		<input type="text" class="form-control col-8" id="chip_id" chipNum="chipId">
 	</div>

<!-- Address -->
	<div class="form-group col-sm-10">
		<legend class="control-legend">Address</legend>
	</div>
	<div class="form-group col-sm-10"> <!-- Street -->
		<label class="control-label">Street</label>
		<input type="text" class="form-control" id="street_id" name="street" >
	</div>					

	<div class="form-group col-sm-10"> <!-- City-->
		<label class="control-label">City</label>
		<input type="text" class="form-control" id="city_id" name="city">
	</div>									

	<div class="form-group col-8"> <!-- State  -->
		<label class="control-label">State</label>
		<select class="form-control" id="state_id">
		<?php
    	include (__DIR__ . "/../php/data_lists/states.html");
		?>
		</select>					
	</div>
	
	<div class="form-group col-4"> <!-- Zip Code-->
		<label class="control-label">Zip Code</label>
	<input class="form-control col-8" type="text" id="zip_id" name="zip">
  </div> 
 
</form>

<!-- Save Button -->
<div class="form-group text-center">
	<button class="btn btn-primary" id="update_pet">Save</button>
</div>

</body>
</html>