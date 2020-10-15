<?php
        function databaseConnect() {
            
            $username = "teampurple2999capstone";
            $password = "$" . "teamPurple" . "!";
            $database = "HelloWorld";
            // Assign $connectionInfo to array of key-value pairs
            $connectionInfo = array("UID" => $username,
                                    "PWD" => $password,
                                    "Database" => $database);
            return sqlsrv_connect("aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com,1433", $connectionInfo);
        }
      function selectTime() {
          $conn = databaseConnect();
          try {
              $sql = "SELECT time FROM TimeStamp WHERE id = (SELECT max(id) FROM TimeStamp)";
              
              $stmt = sqlsrv_query($conn, $sql);
              
              if ($stmt === false):
                echo "Sql Server Error: " . sqlsrv_errors();
              else:
                echo "$('#selectTime').click(function() {";
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "alert('" . $row['time'] . "');";
                }
                echo "});";
              endif;
          } catch (Exception $e) {
              echo "<p>" . $e . "</p>";
          } catch (Throwable $ee) {
              echo "<p>" . $ee . "</p>";
          }
          sqlsrv_close($conn);
      }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Purple B03</title>  

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="stylesheet" href="./css/style.css"/>
  
  
  <link rel="stylesheet" href="./css/bootstrap.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function() {
        $("#enterTime").click(function() {
            $.post({
                url: "./php/enterTime.php",
                data: {enter_time: new Date()}
            });
        });
        <?php selectTime(); ?>
    });
    </script>

</head>

<body>

  <?php
    include ("./php/headernav.html");
  ?>
  
  <div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">Team Purple B03</h1>
            </div>
        </div>
    </div>
  </div>

  <?php
    include ("./php/carousel.html");
  ?>

  <div class="rounded time-stamp-section">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h2 class="h2">Time Stamp</h2>
          <div class="row">
            <div class="col-md-6 text-center">
              <button type="button" class="btn btn-secondary" id="enterTime">Enter Time</button>
            </div>
            <div class="col-md-6 text-center">
              <button type="button" class="btn btn-secondary" id="selectTime">Select Time</button>
            </div>
          </div>
          <br/>
        </div>
      </div>
    </div>
  </div>


</body>
</html>