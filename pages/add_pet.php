
<?php
    include (__DIR__ . "/../php/headernav.html");
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

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">

</head>

<script type="text/javascript">

    $(document).ready(function() {
        $("#addPet").click(function() {
			
			//assign form pieces to variables
			var name = document.getElementById("petname_id").value;
			var speciesRadios = document.getElementsByName("speciesRadios");	//array of different radio buttons
			for(var i = 0;i < speciesRadios.length;i++){
				if(speciesRadios[i].checked) {
					var species = speciesRadios[i].value;
					break;
				}
			}
			var birthdate = document.getElementById("birthday_id").value;
			var weight = document.getElementById("weight_id").value;
			var street = document.getElementById("street_id").value;
			var city = document.getElementById("city_id").value;
			var state = document.getElementById("state_id").value;
			var zip = document.getElementById("zip_id").value;

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
						pet_zip: zip
				}, 
				success: function() {
						location.reload();
						alert("It worked!");
						//location.reload();
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

<form>
	<div class="form-group col-sm-10">
		<legend class="control-legend">Pet</legend>
	</div>
<!-- Name -->
	<div class="form-group col-sm-10">
 		<label class="control-label">Name</label>
 		<input type="text" class="form-control col-8" id="petname_id" name="petname">
 	</div>

<!-- Species -->
	<div class="form-group col-sm-10">
		<label class="col-form-label">Species</label>
	    <div class="form-check">
			<label class="form-check-label">
			<input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios1" value="dog" checked>Dog</label>
  		</div>
    	<div class="form-check">
    		<label class="form-check-label">
    		<input class="form-check-input" type="radio" name="speciesRadios" id="speciesRadios2" value="cat">Cat</label>
    	</div>
  	</div>

<!-- Birth Date -->
	<div class="form-group col-sm-10">
  		<label class="control-label">Birth Date</label>
  		<input class="form-control col-8" type="date" id="birthday_id" name="birthday">
	</div>

<!-- Weight -->
	<div class="form-group col-sm-10">
		<label class="col-form-label">Weight in lbs.</label>
		<input class="form-control" type="number" min="0" step="0.1" pattern="d+(.d{1})?" id="weight_id" placeholder="0.0">
	</div>

<!-- Address -->
	<div class="form-group col-sm-10">
		<legend class="control-legend">Address</legend>
	</div>
	<div class="form-group col-sm-10"> <!-- Street -->
		<label class="control-label">Street</label>
		<input type="text" class="form-control" id="street_id" name="street" >
	</div>					

	<div class="form-group col-sm-10"> <!-- City-->
		<label class="control-label">City</label>
		<input type="text" class="form-control" id="city_id" name="city">
	</div>									

	<div class="form-group col-8"> <!-- State  -->
		<label class="control-label">State</label>
		<select class="form-control" id="state_id">
			<option value="AL">Alabama</option>
			<option value="AK">Alaska</option>
			<option value="AZ">Arizona</option>
			<option value="AR">Arkansas</option>
			<option value="CA">California</option>
			<option value="CO">Colorado</option>
			<option value="CT">Connecticut</option>
			<option value="DE">Delaware</option>
			<option value="DC">District Of Columbia</option>
			<option value="FL">Florida</option>
			<option value="GA">Georgia</option>
			<option value="HI">Hawaii</option>
			<option value="ID">Idaho</option>
			<option value="IL">Illinois</option>
			<option value="IN">Indiana</option>
			<option value="IA">Iowa</option>
			<option value="KS">Kansas</option>
			<option value="KY">Kentucky</option>
			<option value="LA">Louisiana</option>
			<option value="ME">Maine</option>
			<option value="MD">Maryland</option>
			<option value="MA">Massachusetts</option>
			<option value="MI">Michigan</option>
			<option value="MN">Minnesota</option>
			<option value="MS">Mississippi</option>
			<option value="MO">Missouri</option>
			<option value="MT">Montana</option>
			<option value="NE">Nebraska</option>
			<option value="NV">Nevada</option>
			<option value="NH">New Hampshire</option>
			<option value="NJ">New Jersey</option>
			<option value="NM">New Mexico</option>
			<option value="NY">New York</option>
			<option value="NC">North Carolina</option>
			<option value="ND">North Dakota</option>
			<option value="OH">Ohio</option>
			<option value="OK">Oklahoma</option>
			<option value="OR">Oregon</option>
			<option value="PA">Pennsylvania</option>
			<option value="RI">Rhode Island</option>
			<option value="SC">South Carolina</option>
			<option value="SD">South Dakota</option>
			<option value="TN">Tennessee</option>
			<option value="TX">Texas</option>
			<option value="UT">Utah</option>
			<option value="VT">Vermont</option>
			<option value="VA">Virginia</option>
			<option value="WA">Washington</option>
			<option value="WV">West Virginia</option>
			<option value="WI">Wisconsin</option>
			<option value="WY">Wyoming</option>
		</select>					
	</div>
	
	<div class="form-group col-4"> <!-- Zip Code-->
		<label class="control-label">Zip Code</label>
	<input class="form-control col-8" type="text" id="zip_id" name="zip">
  </div> 
 
</form>

<!-- Submit Button -->
<div class="form-group text-center">
	<button type="submit" class="btn btn-primary" id="addPet">Submit</button>
</div>

</body>
</html>