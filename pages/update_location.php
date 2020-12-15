<?php
	require_once "../php/pages-navbar.html";
	require_once "../php/Retrieve-Info.php";
	//include (__DIR__ . "/../php/modals/Modals.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Companion Vault</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
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
        var businessName = document.getElementById("businessname_id");
        var city = document.getElementById("city_id");
        var street = document.getElementById("street_id");
        var state = document.getElementById("state_id");
        var zip = document.getElementById("zip_id");
        var email = document.getElementById("email_id");
        var phone = document.getElementById("phone_id");
        var vetserivce = document.getElementById('vetservice_id');
        var groomingserivce = document.getElementById("groomingservice_id");
        var boardingserivce = document.getElementById("boardingservice_id");
        $('#zip_id').keydown(function(event) {
            return new ContentControl(event).keyboardNumbers();
        });
        $('#phone_id').keydown(function(event) {
            return new ContentControl(event).keyboardNumbers();
        });
        $("#select_location_control").change(function() {
            if (document.getElementById('select_location_control').value !== '') {
                var data = {
                    locationData: ['business', 'veterinary', 'groom', 'board', 'address', 'city', 'state', 'zip', 'email', 'phoneNumber']
                };
                var connect = {
                    directory: 'location'
                };
                var location = {
                    id: idNum.options[idNum.selectedIndex].id
                };
                $.post({
                    url: '../php/add_service.php',
                    data: {
                        fetch: {
                            items: JSON.stringify(data),
                            connect: JSON.stringify(connect),
                            whenever: JSON.stringify(location)
                        }
                    },
                    dataType: 'json',
                    success: function(json) {
                        if (Array.isArray(json)) {
                            for (var index = 0; index < json.length; index++) {
                                document.getElementById("businessname_id").value = json[index]["business"];
                                document.getElementById("street_id").value = json[index]["address"];
                                document.getElementById("city_id").value = json[index]["city"];
                                document.getElementById("state_id").value = json[index]["state"];
                                document.getElementById("zip_id").value = json[index]["zip"];
                                document.getElementById("email_id").value = json[index]["email"];
                                document.getElementById("phone_id").value = json[index]["phoneNumber"];
                                // If Checkbox Statement
                                if (json[index]["veterinary"] == "1") {
                                    document.getElementById("vetservice_id").checked = true;
                                } else {
                                    document.getElementById("vetservice_id").checked = false;
                                }
                                if (json[index]["groom"] == "1") {
                                    document.getElementById("groomingservice_id").checked = true;
                                } else {
                                    document.getElementById("groomingservice_id").checked = false;
                                }
                                if (json[index]["board"] == "1") {
                                    document.getElementById("boardingservice_id").checked = true;
                                } else {
                                    document.getElementById("boardingservice_id").checked = false;
                                }
                            }
                        }
                    }
                });
            } else {
                businessName.value = '';
                street.value = '';
                city.value = '';
                state.value = '';
                zip.value = '';
                email.value = '';
                phone.value = '';
                vetserivce.checked = false;
                groomingserivce.checked = false;
                boardingserivce.checked = false;
            }
        });

        $("#update_location").click(function() {
            //assign form pieces to variables
            if (document.getElementById("vetservice_id").checked) {
                vetserivce = 1
            } else {
                vetserivce = 0
            }
            if (document.getElementById("groomingservice_id").checked) {
                groomingserivce = 1
            } else {
                groomingserivce = 0
            }
            if (document.getElementById("boardingservice_id").checked) {
                boardingserivce = 1
            } else {
                boardingserivce = 0
            }

            var location = {
                business: businessName.value,
                address: street.value,
                city: city.value,
                state: state.value,
                zip: zip.value,
                email: email.value,
                phoneNumber: phone.value,
                veterinary: vetserivce,
                groom: groomingserivce,
                board: boardingserivce
            };
            var connect = {
                directory: 'location'
            };
            var identifer = {
                id: idNum.options[idNum.selectedIndex].id
            }
            //send to file to send to DB
            $.post({
                url: "../php/add_service.php",
                data: {
                    amend: {
                        items: JSON.stringify(location),
                        connect: JSON.stringify(connect),
                        whenever: JSON.stringify(identifer)
                    }
                },
                dataType: 'json',
                success: function(json) {
                    for (var name in json) {
                        switch (name.toUpperCase()) {
                            case 'ERROR':
                                Swal.fire({
                                    icon: 'error',
                                    text: 'An ajax error has occurred, please contact Administrator'
                                })
                                break;
                            case 'SUCCESSFUL':
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Location updated'
                                }).then(result => {
                                    window.location.reload();
                                });
                                break;
                        }
                    }
                    businessName.value = '';
                    street.value = '';
                    city.value = '';
                    state.value = '';
                    zip.value = '';
                    email.value = '';
                    phone.value = '';
                    document.getElementById("vetservice_id").checked = false;
                    document.getElementById("groomingservice_id").checked = false;
                    document.getElementById("boardingservice_id").checked = false;
                }
            });
        });
    });

</script>

<body>

    <div class="container">
        <div class="row">
            <img src=" ../images/title_banner/Update_Location.png" class="img-fluid mx-auto" alt="Update Location">
        </div>
    </div>

    <div id="formContainer">
        <div class="form-group col-8" id="selectContainer">
            <legend class="control-legend" id="select_location">Select a Location</legend>
            <select class="form-control" id="select_location_control">
                <option value=""></option>
                <?php 
                    $retrieveLocation = new DataRetrieval();
                    echo $retrieveLocation->getOptions(array('id', 'business'), 'Locations');
                ?>
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
                <?php include_once ("../php/data_lists/states.html"); ?>
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
