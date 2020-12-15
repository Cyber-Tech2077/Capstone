<?php
	//session_start();
	require_once '../php/pages-navbar.html';
	require_once '../php/Retrieve-Info.php';
	//include (__DIR__ . "/../php/modals/Modals.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Purple B03</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/contentControl.js" type="application/ecmascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link href="../css/bootstrap.min" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/organize_elements.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>

<script type="text/javascript">
    $(document).ready(function() {
        var idNum = document.getElementById("select_pet_control");
        var petName = document.getElementById("petname_id");
        var petBirthDate = document.getElementById("birthday_id");
        var petWeight = document.getElementById("weight_id");
        var petStreet = document.getElementById("street_id");
        var petCity = document.getElementById("city_id");
        var petState = document.getElementById("state_id");
        var petZip = document.getElementById("zip_id");
        var petChip = document.getElementById("chip_id");

        $('#zip_id').keydown(function(event) {
            return new ContentControl().keyboardNumbers(event);
        });

        $("#select_pet_control").change(function() {
            document.getElementById("speciesRadiosOther").value = ""
            var data = {
                petinfo: ['name', 'species', 'birthdate', 'weight', 'street', 'city', 'state', 'zip', 'chipId']
            };
            var petData = {
                id: idNum.options[idNum.selectedIndex].id
            };
            $.post({
                url: '../php/add_service.php',
                data: {
                    fetch: {
                        items: JSON.stringify(data),
                        whenever: JSON.stringify(petData)
                    }
                },
                dataType: 'json',
                success: function(jsonData) {
                    if (Array.isArray(jsonData)) {
                        for (var index = 0; index < jsonData.length; index++) {
                            petName.value = jsonData[index]["name"];
                            if (jsonData[index]["species"] == "Dog") {
                                document.getElementById("speciesRadios1").checked = true;
                            } else if (jsonData[index]["species"] == "Cat") {
                                document.getElementById("speciesRadios2").checked = true;
                            } else {
                                document.getElementById("speciesRadios3").checked = true;
                                document.getElementById("speciesRadiosOther").value = jsonData[index]["species"];
                                $('#speciesRadiosOther').show();
                            }
                            petBirthDate.value = jsonData[index]["birthdate"];
                            petWeight.value = jsonData[index]["weight"];
                            petStreet.value = jsonData[index]["street"];
                            petCity.value = jsonData[index]["city"];
                            petState.value = jsonData[index]["state"];
                            petZip.value = jsonData[index]["zip"];
                            petChip.value = jsonData[index]["chipId"];
                        }
                    }
                }
            })
        });

        $("#update_pet").click(function() {
            // Changed id assocaited with select html element.
            if (document.getElementById("speciesRadios1").checked) {
                var petSpecies = document.getElementById("speciesRadios1").value
            } else if (document.getElementById("speciesRadios2").checked) {
                var petSpecies = document.getElementById("speciesRadios2").value
            } else {
                var petSpecies = document.getElementById("speciesRadiosOther").value
            }

            // Used idNum.options[idNum.selectedIndex].id to fetch the id associated with the
            // selected pet name.
            var params = {
                name: petName.value,
                species: petSpecies,
                birthdate: petBirthDate.value,
                weight: petWeight.value,
                street: petStreet.value,
                city: petCity.value,
                state: petState.value,
                zip: petZip.value,
                chipId: petChip.value
            };
            var when = {
                id: idNum.options[idNum.selectedIndex].id
            };
            $.post({
                url: '../php/add_service.php',
                data: {
                    amend: {
                        items: JSON.stringify(params),
                        whenever: JSON.stringify(when)
                    }
                },
                dataType: 'json',
                success: function(feedback) {
                    for (var jsonKey in feedback) {
                        switch (jsonKey.toUpperCase()) {
                            case 'ERROR':
                                Swal.fire({
                                    icon: 'error',
                                    text: feedback[jsonKey]
                                });
                                break;
                            case 'SUCCESSFUL':
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Pet Updated!'
                                });
                                break;
                        }
                    }
                }
            });
        });
    });

</script>


<body>

    <div class="container">
        <div class="row">
            <img src=" ../images/title_banner/Update_Pet.png" class="img-fluid mx-auto" alt="Update Pet">
        </div>
    </div>

    <div id="formContainer">
        <div class="form-group col-sm-8" id="selectContainer">
            <legend class="control-legend" id="select_pet">Select Pet</legend>
            <select class="form-control col-md-10" id="select_pet_control">
                <!-- Select Pet Dropdown Options - Goes Here -->
                <option value=""></option>
                <?php 
                    $selectPet = new DataRetrieval();
                    echo $selectPet->getOptions(array('id', 'name'));
                ?>
            </select>
        </div>
        <!-- Name -->
        <div class="form-group col-sm-10" id="nameContainer">
            <label class="control-label">Name</label>
            <input type="text" class="form-control col-8" id="petname_id" name="petname" />
        </div>
        <!-- Species -->
        <div class="form-group col-md-8" id="speciesContainer">
            <label class="col-form-label">Species</label>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios1" value="Dog"><label class="form-check-label m-2">Dog</label>
            </div>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios2" value="Cat"><label class="form-check-label m-2">Cat</label>
            </div>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios3" value=""><label class="form-check-label m-2">Other</label>
                <input class="form-control col-sm-7" type="text" id="speciesRadiosOther">​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
            </div>
        </div>
        <!-- Birth Date -->
        <div class="form-group col-sm-8" id="birthContainer">
            <label class="control-label">Birth Date</label>
            <input class="form-control col-8" type="date" id="birthday_id" name="birthday">
        </div>
        <!-- Weight -->
        <div class="form-group col-sm-10" id="weightContainer">
            <label class="col-form-label">Weight in lbs.</label>
            <input class="form-control col-sm-5" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0">
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
                include ("../php/data_lists/states.html");
            ?>
            </select>
        </div>
        <div class="form-group col-4" id="zipContainer">
            <!-- Zip Code-->
            <label class="control-label">Zip Code</label>
            <input class="form-control col-8" type="text" id="zip_id" name="zip">
        </div>
        <br />
        <br />
        <!-- Save Button -->
        <div class="form-group text-center">
            <button class="btn btn-primary" id="update_pet">Save</button>
        </div>
    </div>

</body>

</html>
