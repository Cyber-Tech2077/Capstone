<?php
	include ("../php/headernav.html");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Team Purple B03</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="../js/contentControl.js" type="text/ecmascript"></script>

        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/organize_elements.css"/>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
    </head>

    <script type="text/javascript">
        $(document).ready(function() {
            //Toggle Other Species Text Input
            $(function() {
                $('input[name="speciesRadios"]').on('click', function() {
                    if ($(this).val() == '') {
                        $('#speciesRadiosOther').show();
                    }else {
                        $('#speciesRadiosOther').hide();
                    }
                });
            });
            $('#zip_id').keydown(function(event) {
                return new ContentControl(event).keyboardNumbers();;
            });
            //Assign js variables to html elements and retrieve the values from those html elements
            var name = document.getElementById("petname_id");
            var birthdate = document.getElementById("birthday_id");
            var weight = document.getElementById("weight_id");
            var street = document.getElementById("street_id");
            var city = document.getElementById("city_id");
            var state = document.getElementById("state_id");
            var zip = document.getElementById("zip_id");
            var chipId = document.getElementById("chip_id");
            
            
            $("#addPet").click(function() {
                // Retrieve html element values after form submit
                // 
                if (document.getElementById("speciesRadios1").checked) {
                    var species = document.getElementById("speciesRadios1").value
                }else if (document.getElementById("speciesRadios2").checked){
                    var species = document.getElementById("speciesRadios2").value
                }else{
                    var species = document.getElementById("speciesRadiosOther").value
                }

                //send to file to send to DB
                $.post({
                    url: "../php/add_petDB.php", 
                    data: {	pet_name: name,
                            pet_species: species,
                            pet_birthday: birthdate.value,
                            pet_weight: weight.value,
                            pet_street: street.value,
                            pet_city: city.value,
                            pet_state: state.value,
                            pet_zip: zip.value,
                            pet_chip: chipId.value
                    }, 
                    success: function() {
                        Swal.fire({
                            icon: 'error',
                            text: "This is a test"
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
                      <h1 class="h1">Add a Pet</h1>
                  </div>
              </div>
          </div>
        </div>

        <div id="formContainer">
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
                    <input class="form-control col-sm-6" type="text" id="speciesRadiosOther" />​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
                </div>
            </div>
            
            <!-- Birth Date -->
            <div class="form-group col-sm-10" id="birthContainer">
                <label class="control-label">Birth Date</label>
                <input class="form-control col-sm-6" type="date" id="birthday_id" name="birthday">
            </div>
            
            <!-- Weight -->
            <div class="form-group col-sm-10" id="weightContainer">
                <label class="col-form-label">Weight in lbs.</label>
                <input class="form-control col-sm-5" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0" />
            </div>

            <!-- chipId -->
            <div class="form-group col-sm-10" id="chipContainer">
                <label class="control-label">Chip ID</label>
                <input type="text" class="form-control col-8" id="chip_id" chipNum="chipId" />
            </div>

            <!-- Address -->
            <div class="form-group col-sm-10" id="addressContainer">
                <legend class="control-legend">Address</legend>
            </div>
            <div class="form-group col-sm-8" id="streetContainer">
                <!-- Street -->
                <label class="control-label">Street</label>
                <input type="text" class="form-control" id="street_id" name="street" />
            </div>					

            <div class="form-group col-sm-7" id="cityContainer">
                <!-- City-->
                <label class="control-label">City</label>
                <input type="text" class="form-control" id="city_id" name="city" />
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
                <input class="form-control col-8" maxlength="5" type="text" id="zip_id" name="zip" />
            </div>
            <br/>
            <br/>
            <!-- Submit Button -->
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" id="addPet">Submit</button>
            </div>
        </div>

    </body>
</html>