<?php
	include ("../php/pages-navbar.html");
	//include (__DIR__ . "/../php/modals/Modals.html");
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

    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/organize_elements.css" />

</head>

<script type="text/javascript">
    $(document).ready(function() {
        $("#zip_id").keydown(function(event) {
            return new ContentControl().keyboardNumbers(event);
        });
        $("#phone_id").keydown(function(event) {
            return new ContentControl().keyboardNumbers(event);
        });
        $("#addBusiness").click(function() {

            //assign form pieces to variables
            var name = document.getElementById("businessname_id").value;
            var street = document.getElementById("street_id").value;
            var city = document.getElementById("city_id").value;
            var state = document.getElementById("state_id").value;
            var zip = document.getElementById("zip_id").value;
            var email = document.getElementById("email_id").value;
            var phone = document.getElementById("phone_id").value;
            if (document.getElementById('vetservice_id').checked) {
                var vetservice = 1
            } else {
                var vetservice = 0
            }
            if (document.getElementById('boardingservice_id').checked) {
                var boardingservice = 1
            } else {
                var boardingservice = 0
            }
            if (document.getElementById('groomingservice_id').checked) {
                var groomingservice = 1
            } else {
                var groomingservice = 0
            }
            var locationValues = {
                business: name,
                address: street,
                city: city,
                state: state,
                zip: zip,
                email: email,
                phoneNumber: phone,
                veterinary: vetservice,
                groom: groomingservice,
                board: boardingservice
            };
            var connect = {
                connect: 'location'
            };
            //send to file to send to DB
            $.post({
                url: "../php/add_service.php",
                data: {
                    push: {
                        items: JSON.stringify(locationValues),
                        connect: JSON.stringify(connect)
                    }
                },
                dataType: 'json',
                success: function(json) {
                    for (var response in json) {
                        switch (response.toUpperCase()) {
                            case 'SUCCESSFUL':
                                Swal.fire({
                                    icon: 'success',
                                    text: 'The ' + name + ' location has been added.'
                                }).then(result => {
                                    location.reload();
                                });
                                break;
                            default:
                                Swal.fire({
                                    icon: 'error',
                                    text: 'An ajax error has occurred. Please contact Administrator.'
                                }).then(result => {
                                    location.reload();
                                });
                        }
                    }

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
            <img src=" ../images/title_banner/Add_Location.png" class="img-fluid mx-auto" alt="Add Location">
        </div>
    </div>

    <div id="formContainer">
        <!-- Business Name -->
        <div class="form-group col-sm-10" id="businessContainer">
            <legend class="control-legend">Business Name</legend>
            <input type="text" class="form-control col-sm-8" id="businessname_id" name="name">
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
            <input class="form-control col-8" type="text" maxlength="5" id="zip_id" name="zip">
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
            <input class="form-control col-8" type="text" maxlength="10" id="phone_id" name="phone" />
        </div>
        <br />
        <br />
        <!-- Submit Button -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary" id="addBusiness">Submit</button>
        </div>
    </div>

</body>

</html>
