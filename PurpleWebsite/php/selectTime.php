<?php
        /*function databaseConnect() {
            
            $username = "teampurple2999capstone";
            $password = "$" . "teamPurple" . "!";
            $database = "HelloWorld";
            // Assign $connectionInfo to array of key-value pairs
            $connectionInfo = array("UID" => $username,
                                    "PWD" => $password,
                                    "Database" => $database);
            return sqlsrv_connect("aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com,1433", $connectionInfo);
        }*/

        include_once ("./php/DBConnect.php");
           
      function selectTime() {
          $conn = databaseConnect("HelloWorld");
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