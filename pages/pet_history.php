
<?php
  include (__DIR__ . "/../php/headernav.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pet History</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="../js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  
  <style>
  body{
    background-color:grey;
  }
  table,td{
    border: 2px solid black;
    width: 1100px;
    background-color: lightblue;
  }
  .btn{
    width: 10%;
    height:5%;
    font-size: 22px;
    padding:0px;
  }
  
  </style>

</head>


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

<?php          
            $username = "teampurple2999capstone";
            $password = "$" . "teamPurple" . "!";
            $database = "Pet";
            // Assign $connectionInfo to array of key-value pairs
			$connectionInfo = array("UID" => $username,
			"PWD" => $password,
			"Database" => $database);
            $conn = sqlsrv_connect("aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com,1433", $connectionInfo);
			if ($conn) {
				echo "Database Connection Successful!";
			}
    ?>
<div class="container">
  <form action ="" method="POST">
    <input type="text" name="id" placeholder="Enter pet ID"/>
    <input type="submit" name="search" value="SEARCH BY ID"/>

<table>
<tr>
    <td>Name</td>
    <td>Species</td>
    <td>Birthdate</td>
    <td>weight</td>
  </tr>
  <?php
  
  if (isset($_POST['search']))
  {
      $id = $_POST['id'];
      $sql = "SELECT * FROM Pets where id = '$id'";              
			$stmt = sqlsrv_query($conn, $sql);           
      while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      
	?>
  <tr>
    <td><?php echo $row["name"]; ?></td>
    <td><?php echo $row["species"]; ?></td>
    <td><?php //echo $row["birthdate"]; ?></td>
    <td><?php echo $row["weight"]; ?></td>
</tr>
<?php

        }
      }
				?>
</table>			
<form>
	<div class="form-group col-sm-10">
		<legend class="control-legend">Pet</legend>
	</div>
<!-- Name -->
	<div class="form-group col-sm-10">
 		<label class="control-label">Name</label>
 		
		 <select>
    <option>Select pet name</option>
 <?php   
 
 $sql = "SELECT * FROM Pets";              
 $stmt = sqlsrv_query($conn, $sql); 
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {                   
                    echo '<option>' .$row['name'].'</option>';
                }        
  ?>  
<!-- Select Pet Dropdown Options - Goes Here -->
    </select>



				
</option> 

</form>
</body>
</html>