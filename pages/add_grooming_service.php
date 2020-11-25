
<?php
    //session_start();
    include ("../php/headernav.html");
    include_once ("../php/DBConnect.php");

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

     //Groomer Select?
     function groomerOptions() {
		$conn = databaseConnect("Pet");
		try {
			$sql = "select id, businessName from Locations WHERE  groomerChecked = 1";
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

    <title>Team Purple B03</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../js/contentControl.js" type="application/ecmascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/organize_elements.css" type="text/css" />
    <head></head>
    
    <script type="text/javascript">
        $(document).ready(function() {
            var petChosen = document.getElementById("select_pet_control");
            var grooming_date = document.getElementById("grooming_date_id");
            var locationName= document.getElementById("select_groomer_control");
            var contentDetails = document.getElementById("detail_entry");
            var nailsClipped = document.getElementById("nailsClipped");
            $("#save_grooming_service").click(function() {
                //send to file to send to DB
                $.post({
                    url: "../php/add_gooming_serviceDB.php", 
                    data: {
                        pet_id: petChosen.options[petChosen.selectedIndex].id,
                        serviceDate: grooming_date.value,
                        locationId: locationName.options[locationName.selectedIndex].id,
                        nails_trimmed: nailsClipped.checked,
                        details: contentDetails.value
                    }, success: function() {
                        Swal.fire({
                            icon: 'success',
                            text: 'Grooming service added!'
                        }).then(result => {
                            location.reload();
                        });
                    }, error: function(err){
                        alert("Err " + err);
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
                    <h1 class="h1">Grooming</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div id="formContainer">
        <div class="form-group col-sm-8" id="selectContainer">
            <legend class="control-legend" id="select_pet">Select Pet:</legend>
            <select class="form-control col-md-10" id="select_pet_control">
                <!-- Select Pet Dropdown Options -->
                <option value=""></option>
                <?php comboboxOptions(); ?>
            </select>
        </div>
        <!-- Service Checkbox -->
        <div class="form-group col-sm-5" id="nailsContainer">
            <label class="col-form-label">Service Provided:</label>
            <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="serviceCheckbox" id="nailsClipped" value="nails_trimmed" checked>Nails Trimmed</label>
            </div>
        </div>
        <!-- Groomer dropdown list -->
        <div class="form-group col-sm-10" id="selectContainer">
            <legend class="control-legend" id="select_groomer">Select Groomer</legend>
            <select class="form-control col-md-8" id="select_groomer_control">
                <!-- Select Groomer Dropdown Options -->
                <option value=""></option>
                <?php groomerOptions(); ?>
            </select>
        </div>
        
        <!-- Grooming Service Date -->
        <div class="form-group col-sm-10" id="dateGroomerContainer">
            <legend class="control-legend">Date of Grooming Service:</legend>
            <input class="form-control col-sm-6" type="date" id="grooming_service_date" name="date" />
        </div>
        <!-- Details -->
        <div class="form-group col-sm-10" id="detailsContainer">
            <legend class="control-legend">Enter Details: </legend>
            <textarea class="from-control" id="detail_entry"></textarea>
        </div>
    </div>
    <br />
    <br />
    <!-- Save Button -->
    <div class="form-group text-center">
        <button class="btn btn-primary" id="save_grooming_service">Save</button>
    </div>

</body>

</html>