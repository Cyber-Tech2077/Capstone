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
        $("#addBusiness").click(function() {
			
			//assign form pieces to variables
			var name = document.getElementById("businessname_id").value;
			var street = document.getElementById("street_id").value;
			var city = document.getElementById("city_id").value;
			var state = document.getElementById("state_id").value;
			var zip = document.getElementById("zip_id").value;
			var email = document.getElementById("email_id").value;
			var phone = document.getElementById("phone_id").value;
			if(document.getElementById('vetservice_id').checked) {
				var vetserivce = 1
			}else{
				var vetserivce = 0
			}
			if(document.getElementById('boardingservice_id').checked) {
				var boardingserivce = 1
			}else{
				var boardingserivce = 0
			}
			if(document.getElementById('groomingservice_id').checked) {
				var groomingserivce = 1
			}else{
				var groomingserivce = 0
			}
			//send to file to send to DB
			$.post({
                url: "../php/add_locationDB.php", 
                data: {	business_name: name,
						business_street: street,
						business_city: city,
						business_state: state,
						business_zip: zip,
						business_email: email,
						business_phone: phone,
						business_vetservice: vetserivce,
						business_boardservice: boardingserivce,
						business_groomingservice: groomingserivce,
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
              <h1 class="h1">Add a Location</h1>
          </div>
      </div>
  </div>
</div>

<form>
<!-- Business Name -->
	<div class="form-group col-sm-10">
	<legend class="control-legend">Business Name</legend>
 		<input type="text" class="form-control col-8" id="businessname_id" name="name">
 	</div>

<!-- Business Service Checkboxes -->
	<div class="form-group col-sm-10">
	<legend class="control-legend">Services</legend>
	<div class="row">
		<div class="col">
			<div class="custom-control custom-checkbox mb-3">	<!-- Vet Service -->
				<input type="checkbox" class="custom-control-input" id="vetservice_id" value="">
				<label class="custom-control-label" for="vetservice_id">Veterinary</label>
			</div>
			<div class="custom-control custom-checkbox mb-3">	<!-- Boarding Service -->
				<input type="checkbox" class="custom-control-input" id="boardingservice_id" value="" disabled>
				<label class="custom-control-label" for="boardingservice_id">Boarding</label>
			</div>
			<div class="custom-control custom-checkbox mb-3">	<!-- Grooming Service -->
				<input type="checkbox" class="custom-control-input" id="groomingservice_id" value="" disabled>
				<label class="custom-control-label" for="groomingservice_id">Grooming</label>
			</div>
		</div>
	</div>

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
		<?php
    	include (__DIR__ . "/../php/data_lists/states.html");
		?>
		</select>					
	</div>
	
	<div class="form-group col-4"> <!-- Zip Code-->
		<label class="control-label">Zip Code</label>
		<input class="form-control col-8" type="text" id="zip_id" name="zip">
 	</div> 

<!-- Contact-->
<div class="form-group col-sm-10">
		<legend class="control-legend">Contact</legend>
	</div>

	<div class="form-group col-4">	<!-- Email -->
		<label class="control-label">Email</label>
		<input class="form-control col-8" type="text" id="email_id" name="email">
	</div>
	<div class="form-group col-4">	<!-- Phone -->
		<label class="control-label">Phone Number</label>
		<input class="form-control col-8" type="text" id="phone_id" name="phone">
  	</div>
</form>

</form>
<!-- Submit Button -->
<div class="form-group text-center">
	<button type="submit" class="btn btn-primary" id="addBusiness">Submit</button>
</div>

</body>
</html>