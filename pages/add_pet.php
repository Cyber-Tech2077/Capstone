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
  <script src="../js/sweetalert2.js" type="text/javascript"></script>
  <link rel="stylesheet" href="../css/sweetalert2.css"/>
  <link rel="stylesheet" href="../css/style.css"/>
    <link rel="stylesheet" href="../css/organize_elements.css"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css"/>

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

        $("#addPet").click(function() {
			//assign form pieces to variables
			var name = document.getElementById("petname_id").value;

			if (document.getElementById("speciesRadios1").checked) {
				var species = document.getElementById("speciesRadios1").value
			}else if (document.getElementById("speciesRadios2").checked){
				var species = document.getElementById("speciesRadios2").value
			}else{
				var species = document.getElementById("speciesRadiosOther").value
			}

			var birthdate = document.getElementById("birthday_id").value;
			var weight = document.getElementById("weight_id").value;
			var street = document.getElementById("street_id").value;
			var city = document.getElementById("city_id").value;
			var state = document.getElementById("state_id").value;
			var zip = document.getElementById("zip_id").value;
			var chipId = document.getElementById("chip_id").value;

			//send to file to send to DB
			$.post({
                url: "../php/add_petDB.php", 
                data: {	pet_name: name,
						pet_species: species,
						pet_birthday: birthdate,
						pet_weight: weight,
						pet_street: street,
						pet_city: city,
						pet_state: state,
						//pet_zip: zip,
						pet_chip: chipId
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
 		<input type="text" class="form-control col-8" id="petname_id" name="petname">
 	</div>

<!-- Species -->
	<div class="form-group col-sm-10" id="speciesContainer">
		<label class="col-form-label">Species</label>
        <div id="speciesToolContainer">
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios1" value="Dog"><label class="form-check-label m-2">Dog</label>
            </div>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios2" value="Cat"><label class="form-check-label m-2">Cat</label>
            </div>
            <div class="form-check form-inline">
                <input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios3" value=""><label class="form-check-label m-2">Other</label>
                <input class="form-control col-4" type="text" id="speciesRadiosOther">​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
            </div>
        </div>
  	</div>

<!-- Birth Date -->
	<div class="form-group col-sm-10" id="birthContainer">
  		<label class="control-label">Birth Date</label>
  		<input class="form-control col-8" type="date" id="birthday_id" name="birthday">
	</div>

<!-- Weight -->
	<div class="form-group col-sm-10" id="weightContainer">
		<label class="col-form-label">Weight in lbs.</label>
		<input class="form-control" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0">
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
	<div class="form-group col-sm-10" id="streetContainer">
        <!-- Street -->
		<label class="control-label">Street</label>
		<input type="text" class="form-control" id="street_id" name="street" >
	</div>					

	<div class="form-group col-sm-10" id="cityContainer">
        <!-- City-->
		<label class="control-label">City</label>
		<input type="text" class="form-control" id="city_id" name="city">
	</div>									

	<div class="form-group col-8" id="stateContainer">
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
 
</div>
    <br/>
    <br/>
<!-- Submit Button -->
<div class="form-group text-center">
	<button type="submit" class="btn btn-primary" id="addPet">Submit</button>
</div>

</body>
</html>