<?php
	include (__DIR__ . "/../php/pages-navbar.html");
	include_once(__DIR__."/../php/DBConnect.php");
	//include (__DIR__ . "/../php/modals/Modals.html");
	
	function comboboxOptions() {
		// This php code works, all values come out as normal.
		// No need to mess with this.
		$conn = databaseConnect("Pet");
		try {
			$sql = "select id, business from Locations";
			$stmt = sqlsrv_query($conn, $sql);
			if ($stmt === false) {
				echo "Error Occurred: " . sqlsrv_errors();
			} else {
				$storeValueId;
				while ($row = sqlsrv_fetch_object($stmt)) {
					echo "<option id = " . $row->id . " value = " . $row->business . ">" . $row->business . "</option>";
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
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../js/contentControl.js" type="text/ecmascript"></script>
    <script src="../js/secondnav_toggle.js" type="text/ecmascript"></script>

    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/organize_elements.css" type="text/css" />

</head>

<script type="text/javascript">
    $(document).ready(function() {
        var idNum = document.getElementById("select_location_control");
        $('#zip_id').keydown(function(event) {
            return new ContentControl(event).keyboardNumbers();
        });
        $('#phone_id').keydown(function(event) {
            return new ContentControl(event).keyboardNumbers();
        });
        $("#select_location_control").change(function() {
            if (document.getElementById('select_location_control').value !== '') {
                $.post({
                    url: "../php/retrieve_location.php",
                    data: {
                        location_ID: idNum.options[idNum.selectedIndex].id
                    },
                    dataType: 'json',
                    success: function(json) {
                        document.getElementById("businessname_id").value = json["Name"];
                        document.getElementById("street_id").value = json["Street"];
                        document.getElementById("city_id").value = json["City"];
                        document.getElementById("state_id").value = json["State"];
                        document.getElementById("zip_id").value = json["Zip"];
                        document.getElementById("email_id").value = json["Email"];
                        document.getElementById("phone_id").value = json["Phone"];
                        // If Checkbox Statement
                        if (json["vetService"] == "1") {
                            document.getElementById("vetservice_id").checked = true;
                        } else {
                            document.getElementById("vetservice_id").checked = false;
                        }
                        if (json["groomService"] == "1") {
                            document.getElementById("groomingservice_id").checked = true;
                        } else {
                            document.getElementById("groomingservice_id").checked = false;
                        }
                        if (json["boardService"] == "1") {
                            document.getElementById("boardingservice_id").checked = true;
                        } else {
                            document.getElementById("boardingservice_id").checked = false;
                        }

                    }
                });
            } else {
                document.getElementById("businessname_id").value = '';
                document.getElementById("street_id").value = '';
                document.getElementById("city_id").value = '';
                document.getElementById("state_id").value = '';
                document.getElementById("zip_id").value = '';
                document.getElementById("email_id").value = '';
                document.getElementById("phone_id").value = '';
                document.getElementById("vetservice_id").checked = false;
                document.getElementById("groomingservice_id").checked = false;
                document.getElementById("boardingservice_id").checked = false;

            }
        });

        $("#update_location").click(function() {
            //assign form pieces to variables
            if (document.getElementById("vetservice_id").checked) {
                var vetserivce = 1
            } else {
                var vetserivce = 0
            }
            if (document.getElementById("groomingservice_id").checked) {
                var groomingserivce = 1
            } else {
                var groomingserivce = 0
            }
            if (document.getElementById("boardingservice_id").checked) {
                var boardingserivce = 1
            } else {
                var boardingserivce = 0
            }

            var businessName = document.getElementById("businessname_id");

            //send to file to send to DB
            $.post({
                url: "../php/update_locationDB.php",
                data: {
                    business_name: businessName.value,
                    business_street: document.getElementById("street_id").value,
                    business_city: document.getElementById("city_id").value,
                    business_state: document.getElementById("state_id").value,
                    business_zip: document.getElementById("zip_id").value,
                    business_email: document.getElementById("email_id").value,
                    business_phone: document.getElementById("phone_id").value,
                    business_vetservice: vetserivce,
                    business_groomingservice: groomingserivce,
                    business_boardservice: boardingserivce,
                    location_ID: idNum.options[idNum.selectedIndex].id
                },
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        text: 'The ' + businessName.value + ' location has been updated.'
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
                    <h1 class="h1">Update a Location</h1>
                </div>
            </div>
        </div>
    </div>

    <div id="formContainer">
        <div class="form-group col-8" id="selectContainer">
            <legend class="control-legend" id="select_location">Select a Location</legend>
            <select class="form-control" id="select_location_control">
                <option value=""></option>
                <?php comboboxOptions(); ?>
            </select>
        </div>

        <!-- Business Name -->
        <div class="form-group col-sm-10" id="businessContainer">
            <legend class="control-legend">Business Name</legend>
            <input type="text" class="form-control col-8" id="businessname_id" name="name">
        </div>

        <!-- Business Service Checkboxes -->
        <div class="form-group col-sm-10" id="servicesContainer">
            <legend class="control-legend">Services</legend>
            <div class="row">
                <div class="col">
                    <div class="custom-control custom-checkbox mb-3">
                        <!-- Vet Service -->
                        <input type="checkbox" class="custom-control-input" id="vetservice_id" value="">
                        <label class="custom-control-label" for="vetservice_id">Veterinary</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <!-- Grooming Service -->
                        <input type="checkbox" class="custom-control-input" id="groomingservice_id" value="">
                        <label class="custom-control-label" for="groomingservice_id">Grooming</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <!-- Boarding Service -->
                        <input type="checkbox" class="custom-control-input" id="boardingservice_id" value="">
                        <label class="custom-control-label" for="boardingservice_id">Boarding</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address -->
        <div class="form-group col-sm-10" id="addressContainer">
            <legend class="control-legend">Address</legend>
        </div>
        <div class="form-group col-sm-8" id="streetContainer">
            <!-- Street -->
            <label class="control-label">Street</label>
            <input type="text" class="form-control" id="street_id" name="street">
        </div>

        <div class="form-group col-sm-7" id="cityContainer">
            <!-- City-->
            <label class="control-label">City</label>
            <input type="text" class="form-control" id="city_id" name="city">
        </div>

        <div class="form-group col-sm-7" id="stateContainer">
            <!-- State  -->
            <label class="control-label">State</label>
            <select class="form-control" id="state_id">
                <?php
            include_once ("../php/data_lists/states.html");
            ?>
            </select>
        </div>

        <div class="form-group col-4" id="zipContainer">
            <!-- Zip Code-->
            <label class="control-label">Zip Code</label>
            <input class="form-control col-8" type="text" id="zip_id" name="zip">
        </div>

        <!-- Contact-->
        <div class="form-group col-sm-10" id="contactContainer">
            <legend class="control-legend">Contact</legend>
        </div>

        <div class="form-group col-md-12" id="emailContainer">
            <!-- Email -->
            <label class="control-label">Email</label>
            <input class="form-control col-8" type="text" id="email_id" name="email">
        </div>
        <div class="form-group col-sm-8" id="phoneContainer">
            <!-- Phone -->
            <label class="control-label">Phone Number</label>
            <input class="form-control col-8" type="text" maxlength="10" id="phone_id" name="phone">
        </div>
        <br />
        <br />
        <!-- Submit Button -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary" id="update_location">Save</button>
        </div>
    </div>

</body>

</html>