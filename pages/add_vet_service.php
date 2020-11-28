<?php
    session_start();
    include ("../php/headernav.html");
    include_once("../php/DBConnect.php");
    include (__DIR__ . "/../php/modals/Modals.html");

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

    //Vet Selector
	function chooseLocation() {
		$conn = databaseConnect("Pet");
		try {
			$sql = "select id, businessName from Locations WHERE vetChecked = 1";
			$stmt = sqlsrv_query($conn, $sql);
			if ($stmt === false) {
				echo "Error Occurred: " . sqlsrv_errors();
			} else {
				$storeValueId;
				while ($row = sqlsrv_fetch_object($stmt)) {
					echo "<option id = " . $row->id . " value = " . $row->businessName . ">" . $row->businessName . "</option>";
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
<head>
    <title>Team Purple B03</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<script type="text/javascript">
    $(document).ready(function() {
        $("#save_service").click(function() {

            
            var petChosen = (document.getElementById("select_pet_control"));
            var location = document.getElementById("select_location_control");
            var text = document.getElementById("detail_entry").value;

			$.post({
				url: "../php/add_vet_serviceDB.php", 
                data: { petId: petChosen.options[petChosen.selectedIndex].id, 
                        serviceDate: document.getElementById("service_date_id").value,
                        locationId: location.options[location.selectedIndex].id,
                        details: text

                    }, 
                    success: function() {
					    $('#addition_successful').modal();
				    },
				    error: function(err) {
					    alert("Err " + err);
				    }
			});
        });
    });
</script>
<body>

<div class="container">
  <div class="row">
	  <img src=" ../images/title_banner/Add_Veterinary_Service.png" class="img-fluid mx-auto" alt="Add Veterinary Service">
  </div>
</div>

<form>
<div class="row">
	<div class="col-md-6">
		<!-- Pet Name -->
		<div class="form-group col-md-12">
            <legend class="control-legend" id="select_pet">For</legend>
            <select class="form-control col-8" id="select_pet_control" required>
                <!-- Select Pet Dropdown Options -->
                <option value="" selected disabled>Select Pet</option>
                <?php comboboxOptions(); ?>
            </select>					
        </div>   
        <div class="form-group col-12">
            <legend class="control-legend" id="select_location">Veterinary Location</legend>
            <select class="form-control col-8" id="select_location_control" required>
                <!-- Select Location Dropdown Options -->
                <option value="" selected disabled>Select Veterinary</option>
                <?php chooseLocation(); ?>
            </select>					
        </div>
        <!-- Veterinary Service Date -->
        <div class="form-group col-lg-10">
            <legend class="control-legend">Date of Veterinary Service</legend>
            <input class="form-control col-5 col-sm-7 col-md-6 col-lg-5 col-xl-4" type="date" id="service_date_id">
        </div>
    </div>
</div>
    <!-- Details -->
<div class="col-md-6 mx-auto">
    <div class="form-group">
        <legend class="control-legend">Enter Details</legend>
        <textarea class="form-control" rows="9" cols="50" id="detail_entry" placeholder="Enter Details..."></textarea>
    </div>
</div>
</form>

    <!-- Save Button -->
<div class="form-group text-center">
    <button class="btn btn-primary" id="save_service">Save</button>
</div>

</body>
</html>