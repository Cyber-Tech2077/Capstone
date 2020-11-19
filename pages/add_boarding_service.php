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
    
    function boardingLocations() {
        $conn = databaseConnect("Pet");
		try {
			$sql = "select id, businessName as name from Locations where boarderChecked = '1'";
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

<script type="text/javascript">

    $(document).ready(function(){
        var currentMonth = new Date().getMonth();
        if (currentMonth > 0 && currentMonth < 10) {
            currentMonth = "0" + currentMonth;
        } else {
            currentMonth += 1;
        }
        var currentDay = new Date().getDate();
        if (currentDay < 10) {
            currentDay = "0" + currentDay;
        }
        document.getElementById("service_date_id").setAttribute("min", new Date().getFullYear() + "-" + currentMonth + "-" + currentDay);
        $("#save_service").click(function(){
            
            if (document.getElementById("select_pet_control").value == "" && document.getElementById("select_boarding_location").value == "" && document.getElementById("service_date_id").value == "") {
                alert("You must select a pet name, boarding location and service date.");
                return;
            } else if (document.getElementById("select_pet_control").value == "" && document.getElementById("select_boarding_location").value == "") {
                alert("You must select a pet name and boarding location.");
                return;
            } else if (document.getElementById("select_boarding_location").value == "" && document.getElementById("service_date_id").value == "") {
                alert("You must select a boarding location and a service date.");
                return;
            } else if (document.getElementById("service_date_id").value == "") {
                alert("You must select a service date.");
                return;
            } else if (document.getElementById("select_pet_control").value == "") {
                alert("You must select a pet name.");
                return;
            } else if (document.getElementById("select_boarding_location").value == "") {
                alert("You must select a boarding location.");
                return;
            }
            
            var startDate = document.getElementById("service_date_id").value;
            var petChosen = document.getElementById("select_pet_control");
            var boardingChosen = document.getElementById("select_boarding_location");
            
            $.post({
                url: "../php/add_boarding_serviceDB.php",
                data: {
                    service_date: startDate,
                    boarding_location: boardingChosen.options[boardingChosen.selectedIndex].id,
                    pet_id: petChosen.options[petChosen.selectedIndex].id
                }, success: function(response) {
                    if (response !== "") {
                        alert(response);
                    } else {
                        alert(petChosen.value + "'s boarding session added for " + startDate + ". See you then!", "Boarding Service");
                    }
                    location.reload();
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
                <h1 class="h1">Add a Boarding Service</h1>
            </div>
        </div>
    </div>
    </div>

    <div class="form-group col-8">
	    <legend class="control-legend" id="select_pet">Pet Name</legend>
        <select class="form-control" id="select_pet_control" required>

            <!-- Select Pet Dropdown Options -->
            <option value=""></option>
            <?php comboboxOptions(); ?>

        </select>					
    </div>
    
    <div class="form-group col-8">
	    <legend class="control-legend" id="select_pet">Choose Boarding Location</legend>
        <select class="form-control" id="select_boarding_location" required>

            <!-- Select Pet Dropdown Options -->
            <option value=""></option>
            <?php boardingLocations(); ?>

        </select>					
    </div>
    
    <form>
        <!-- Service Date -->
        <div class="form-group col-sm-10">
            <legend class="control-legend">Start Date for Boarding Service</legend>
            <input class="form-control col-8" type="date" id="service_date_id" name="service_date"/>
        </div>

    </form>

    <!-- Save Button -->
    <div class="form-group text-center">
        <button class="btn btn-primary" id="save_service">Save</button>
    </div>

</body>
</html>