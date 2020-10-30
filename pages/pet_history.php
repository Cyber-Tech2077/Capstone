
<?php
	session_start();
	include ("../php/headernav.html");
	include ("../php/petHistoryDB.php");

	

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Purple B03</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <style href="../css/bootstrap.min" rel="stylesheet" type="text/css"></style>
  <script src="../js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">	
</head>

<script type="text/javascript">

	$(document).ready(function() {
		$("#selectHistory").click(function() {

			var petChosen = document.getElementsByName("petSelector");
			for(var i = 0;i < petChosen.length;i++){
				if(petChosen[i].selected) {
					var pet = petChosen[i].id;
					break;
				}
			}

			//alert(pet);

			$.post({
				url: "../php/petHistoryDB.php",
				data: { pet_id: pet },
				success: function() {
					alert("It worked!");
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
              <h1 class="h1">Pet History</h1>
          </div>
      </div>
  </div>
</div>

<div class="form-group col-8">
	<legend class="control-legend" id="select_pet">Select Pet</legend>
	<select class="form-control" id="select_pet">

		<!-- Select Pet Dropdown Options - Goes Here -->
		<?php comboboxOptions(); ?>

	</select>					
</div>

<div class="form-group text-center">
	<button type="submit" class="btn btn-primary" id="selectHistory">Submit</button>
</div>

<div class="table" id="outputHistory">
	<thead>
		<tr>
			<th scope="col">ID #</th>
			<th scope="col">Pet</th>
			<th scope="col">Service</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
</div>

</body>
</html>