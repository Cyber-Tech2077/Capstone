
<?php
	//session_start();
	include ("../php/headernav.html");
	include_once("../php/DBConnect.php");
	//include (__DIR__ . "/../php/modals/Modals.html");

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="stylesheet" href="../css/style.css"/>
    <link rel="stylesheet" href="../css/organize_elements.css"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css"/>	
</head>

<script type="text/javascript">

	$(document).ready(function() {
		var idNum = document.getElementById("select_pet_control");
        var petName = document.getElementById("petname_id");
		$("#select_pet_control").change(function(){
			document.getElementById("speciesRadiosOther").value = ""
			$.post({
				url: "../php/retrieve_pet.php",
				data: {pet_ID: idNum.options[idNum.selectedIndex].id},
                dataType: 'json',
				success: function(jsonData){
					petName.value = jsonData["Name"];
					if (jsonData["Species"]=="Dog"){
						document.getElementById("speciesRadios1").checked = true;
					} else if (jsonData["Species"]=="Cat"){
						document.getElementById("speciesRadios2").checked = true;
					}else{
						document.getElementById("speciesRadios3").checked = true;
						document.getElementById("speciesRadiosOther").value = jsonData["Species"];
						$('#speciesRadiosOther').show();
					}
					//  .toISOString().slice(0, 19).replace('T', ' ');
					//  JSON.stringify(exampleObj)
					
					document.getElementById("birthday_id").value = jsonData["Birthdate"];
					document.getElementById("weight_id").value = jsonData["Weight"];
					document.getElementById("street_id").value = jsonData["Street"];
					document.getElementById("city_id").value = jsonData["City"];
					document.getElementById("state_id").value = jsonData["State"];
					document.getElementById("zip_id").value = jsonData["Zip"];
					document.getElementById("chip_id").value = jsonData["Chip"];				
				}
				
			});
		});
		
		$("#update_pet").click(function() {
			// Changed id assocaited with select html element.
			if (document.getElementById("speciesRadios1").checked) {
				var petSpecies = document.getElementById("speciesRadios1").value
			}else if (document.getElementById("speciesRadios2").checked){
				var petSpecies = document.getElementById("speciesRadios2").value
			}else{
				var petSpecies = document.getElementById("speciesRadiosOther").value
			}

			// Used idNum.options[idNum.selectedIndex].id to fetch the id associated with the
			// selected pet name.
			$.post({
				url: "../php/update_petDB.php",
				data: {	pet_name: petName.value, 
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
					Swal.fire({
                        icon: 'success',
                        text: petName.value + " has been updated successfully!"
                    }).then(result => {
                        location.reload();
                    });
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

<div id="formContainer">
    <div class="form-group col-8" id="selectContainer">
        <legend class="control-legend" id="select_pet">Select Pet</legend>
        <select class="form-control" id="select_pet_control" >
            <!-- Select Pet Dropdown Options - Goes Here -->
            <option value=""></option>
            <?php comboboxOptions(); ?>
        </select>
    </div>
    <!-- Name -->
    <div class="form-group col-sm-10" id="nameContainer">
        <label class="control-label">Name</label>
        <input type="text" class="form-control col-8" id="petname_id" name="petname"/>
    </div>
    <!-- Species -->
    <div class="form-group col-sm-10" id="speciesContainer">
        <label class="col-form-label">Species</label>
        <div id="speciesToolContainer">
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios1" value="Dog"><label class="form-check-label m-2">Dog</label>
            </div>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios2" value="Cat"><label class="form-check-label m-2">Cat</label>
            </div>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios3" value=""><label class="form-check-label m-2">Other</label>
                <input class="form-control col-4" type="text" id="speciesRadiosOther">​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
            </div>
        </div>
    </div>
    <!-- Birth Date -->
    <div class="form-group col-sm-10" id="birthContainer">
        <label class="control-label">Birth Date</label>
        <input class="form-control col-8" type="date" id="birthday_id" name="birthday">
    </div>
    <!-- Weight -->
    <div class="form-group col-sm-10" id="weightContainer">
        <label class="col-form-label" id="weightLabel">Weight in lbs.</label>
        <input class="form-control" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0">
    </div>
    <!-- chipId -->
    <div class="form-group col-sm-10" id="chipContainer">
        <label class="control-label">Chip ID</label>
        <input type="text" class="form-control col-8" id="chip_id" chipNum="chipId">
    </div>
    <!-- Address -->
    <div class="form-group col-sm-10" id="addressContainer">
        <legend class="control-legend" id="addressLbl">Address</legend>
    </div>
    <div class="form-group col-sm-10" id="streetContainer">
        <!-- Street -->
        <label class="control-label">Street</label>
        <input type="text" class="form-control" id="street_id" name="street" >
    </div>					
    <div class="form-group col-sm-10" id="cityContainer">
        <!-- City-->
        <label class="control-label">City</label>
        <input type="text" class="form-control" id="city_id" name="city">
    </div>
    <div class="form-group col-8" id="stateContainer">
        <!-- State  -->
        <label class="control-label">State</label>
        <select class="form-control" id="state_id">
            <?php
                include ("../php/data_lists/states.html");
            ?>
        </select>
    </div>
    <div class="form-group col-4" id="zipContainer">
        <!-- Zip Code-->
        <label class="control-label">Zip Code</label>
        <input class="form-control col-8" type="text" id="zip_id" name="zip">
    </div>
    <br/>
    <br/>
    <!-- Save Button -->
    <div class="form-group text-center">
        <button class="btn btn-primary" id="update_pet">Save</button>
    </div>
</div>

</body>
</html>