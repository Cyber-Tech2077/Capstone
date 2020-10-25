<?php
    session_start();
    function connectionString() {
        $username = "teampurple2999capstone";
        $password = "$" . "teamPurple" . "!";
        $database = "Pet";
        // Assign $connectionInfo to array of key-value pairs.
        $connectionInfo = array("UID" => $username,
                                "PWD" => $password,
                                "Database" => $database);
        // Connect to sql server using server name and array of key-value pairs to complete connection string.
        return sqlsrv_connect("aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com, 1433", $connectionInfo);
    }
    function select_DateTime() {
        $conn;
        try {

            $conn = connectionString();
            
            $sql = "select id, name from Pets";
            // Query execute using sql server function.
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false):
                echo "Sql Server Error: " . sqlsrv_errors();
            else:
                // Make sure to add this line for the javascript.
                echo "<p>";

                // Assign sql results in array form to a $row variable.
                while($row = sqlsrv_fetch_object($stmt) ) {
                    // Using javascript, alert the user on the page, the record result.
                    echo "$row->id,$row->name </br>";
                }
                // This is the closing brackets for the click function.
                // This must be added as well.
                echo "</p>";
            endif;
            // Close connection to database.
            sqlsrv_close($conn);
        } catch (Exception $e) {
            echo "<p>" . $e . "</p>";
        } catch (Throwable $ee) {
            echo "<p>" . $ee . "</p>";
        }
        
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Garrett Moore</title>
    </head>
    <body>
        <button id="learning-sql">Click Here!</button>
        <?php 
            // Call PHP function from above.
            select_DateTime();
        ?>
        <!-- JQuery CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            // Initialize JQuery
            $(document).ready(function() {
                $("#learning-sql").click(function() {
                    $.post({
                        url: "./learning-sql/post-usages/insert-duplicate.php",
                        data: {currentMonth: "learning-sql"},
                        success: function() {
                            alert("Successful!");
                        }
                    });
                });
            });
        </script>
    </body>
</html>