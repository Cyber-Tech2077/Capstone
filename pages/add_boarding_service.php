<?php
    session_start();
    require_once '../php/pages-navbar.html';
    require_once '../php/Retrieve-Info.php';
?>
<!DOCTYPE html>
<html>

<title>Team Purple B03</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="../js/contentControl.js" type="text/ecmascript"></script>

<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/organize_elements.css" />

<head>
</head>

<script type="text/javascript">
    $(document).ready(function() {
        var startDate = document.getElementById("boarding_service_date");
        var petChosen = document.getElementById("select_pet_control");
        var boardingChosen = document.getElementById("select_boarding_location");
        var text = document.getElementById("detail_entry").value;

        var limitDatePeriod = new ContentControl(null);
        startDate.setAttribute("min", limitDatePeriod.limitedDatePeriod());
        $("#save_service").click(function() {

            if (document.getElementById("select_pet_control").value == "" && document.getElementById("select_boarding_location").value == "" && startDate.value == "") {
                alert("You must select a pet name, boarding location and service date.");
                return;
            } else if (document.getElementById("select_pet_control").value == "" && document.getElementById("select_boarding_location").value == "") {
                alert("You must select a pet name and boarding location.");
                return;
            } else if (document.getElementById("select_boarding_location").value == "" && startDate.value == "") {
                alert("You must select a boarding location and a service date.");
                return;
            } else if (startDate.value == "") {
                alert("You must select a service date.");
                return;
            } else if (document.getElementById("select_pet_control").value == "") {
                alert("You must select a pet name.");
                return;
            } else if (document.getElementById("select_boarding_location").value == "") {
                alert("You must select a boarding location.");
                return;
            }
            var detailEntry = document.getElementById("detail_entry");
            var jsonParams = {
                petId: petChosen.options[petChosen.selectedIndex].id,
                serviceName: 'Boarding',
                locationId: boardingChosen.options[boardingChosen.selectedIndex].id,
                serviceDate: startDate.value,
                serviceDetails: detailEntry.value
            }
            $.post({
                url: "../php/add_service.php",
                data: {
                    push: {
                        items: JSON.stringify(jsonParams),
                        connect: 'history'
                    }
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        text: petChosen.value + "'s boarding session added for " + startDate.value + '. See you then!'
                    }).then(result => {
                        location.reload();
                    });
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        text: 'An ajax post call error has occurred: ' + err
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
                    <h1 class="h1">Add a Boarding Service</h1>
                </div>
            </div>
        </div>
    </div>

    <div id="formContainer">

        <div class="form-group col-8" id="selectContainer">
            <legend class="control-legend" id="select_pet">Pet Name</legend>
            <select class="form-control" id="select_pet_control" required>
                <!-- Select Pet Dropdown Options -->
                <option value=""></option>
                <?php
                    $retrievePet = new DataRetrieval();
                    echo $retrievePet->getOptions(array('id', 'name'));
                ?>
            </select>
        </div>

        <div class="form-group col-sm-10" id="selectContainer">
            <legend class="control-legend" id="select_pet">Choose Boarding Location</legend>
            <select class="form-control col-md-8" id="select_boarding_location" required>
                <!-- Select Pet Dropdown Options -->
                <option value=""></option>
                <?php
                    $retrieveLocation = new DataRetrieval();
                    echo $retrieveLocation->getOptions(array('id', 'business'), 'Locations');
                ?>

            </select>
        </div>
        <!-- Service Date -->
        <div class="form-group col-sm-12" id="boardingServiceContainer">
            <legend class="control-legend">Start Date for Boarding Service</legend>
            <input class="form-control col-sm-5" type="date" id="boarding_service_date" name="service_date" require />

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
        <button class="btn btn-primary" id="save_service">Save</button>
    </div>

</body>

</html>
