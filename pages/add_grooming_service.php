<?php
    //session_start();
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
<script src="../js/contentControl.js" type="application/ecmascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/organize_elements.css" type="text/css" />

<head></head>

<script type="text/javascript">
    $(document).ready(function() {
        var petChosen = document.getElementById("select_pet_control");
        var grooming_date = document.getElementById("grooming_service_date");
        var locationName = document.getElementById("select_groomer_control");
        var contentDetails = document.getElementById("detail_entry");
        $("#save_grooming_service").click(function() {
            //send to file to send to DB
            var chosenPet = {
                petGrooming: {
                    petId: petChosen.options[petChosen.selectedIndex].id,
                    serviceName: 'Grooming',
                    serviceDate: grooming_date.value,
                    locationId: locationName.options[locationName.selectedIndex].id,
                    serviceDetails: contentDetails.value
                }
            };
            $.post({
                url: "../php/add_service.php",
                data: {
                    groomingData: JSON.stringify(chosenPet)
                },
                dataType: 'json',
                success: function(feedback) {
                    Swal.fire({
                        icon: 'success',
                        text: 'Grooming service added!'
                    }).then(result => {
                        location.reload();
                    });
                },
                error: function(err) {
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
                <?php 
                    $retrievePet = new DataRetrieval();
                    echo $retrievePet->getOptions(array('id', 'name'));
                ?>
            </select>
        </div>
        <!-- Groomer dropdown list -->
        <div class="form-group col-sm-10" id="selectContainer">
            <legend class="control-legend" id="select_groomer">Select Groomer</legend>
            <select class="form-control col-md-8" id="select_groomer_control">
                <!-- Select Groomer Dropdown Options -->
                <option value=""></option>
                <?php 
                    $retrieveLocation = new DataRetrieval();
                    echo $retrieveLocation->getOptions(array('id', 'business'), 'Locations');
                ?>
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
