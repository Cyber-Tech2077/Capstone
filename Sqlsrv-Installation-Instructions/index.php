<!DOCTYPE html>
<html>

    <head><title>SQL Server XAMPP Installation</title></head>
    <style>
        body {
             background-color: #ff5733;
        }
        .sqlServerDocumentTitle {
            height: 60px;
            width: 335px;
            font-size: 25px;
            margin: auto;
        }
        .installationSection {
            height: 2450px;
            width: 650px;
            margin: auto;
        }
    </style>
    <body>
        <div class="installationSection">
            <div class="sqlServerDocumentTitle"><p>SQL Server XAMPP Installation</p></div>
            <ol>
                <li>Click on the link and save the file. This is a Microsoft application that contains all the necessary driver files for PHP SQL Server. <a href="https://go.microsoft.com/fwlink/?linkid=2120362">Download Microsoft Drivers for PHP SQL Server (Windows) </a></li>
                <br/>
                <li>Click "Yes" to get past the Microsoft License Terms agreement page.</li>
                <br/>
                <li>Click "browse" and locate your "xampp" folder in your file system. Then go into the "php" folder, then "ext".</li>
                <br/>
                <li>Your final result should look something like this: <img src="./img/extract-destination-files.jpg"/><br/>Click "OK" to extract the SQL Server driver files.</li>
                <br/>
                <li>Go to your xampp application: <img src="./img/xampp-application.jpg"/> and click on "Config" highlighted in <color style="color: red;font-size: 20px;">red</color>.</li>
                <br/>
                <li>Then, click "php.ini" in the context menu highlighted in <color style="color: #357EC7;font-size: 20px;">light-blue</color>.<img src="./img/xampp-php-ini-shortcut.jpg"/></li>
                <br/>
                <li>Copy and paste these extension lines in your php.ini file:
                    <br/>
                    <br/>
                    <ul>
                        <li>
                            extension=sqlsrv_72_nts_x64
                            <br/>
                            extension=sqlsrv_72_nts_x86
                            <br/>
                            extension=sqlsrv_72_ts_x64
                            <br/>
                            extension=sqlsrv_72_ts_x86
                            <br/>
                            extension=sqlsrv_73_nts_x64
                            <br/>
                            extension=sqlsrv_73_nts_x86
                            <br/>
                            extension=sqlsrv_73_ts_x64
                            <br/>
                            extension=sqlsrv_73_ts_x86
                            <br/>
                            extension=sqlsrv_74_nts_x64
                            <br/>
                            extension=sqlsrv_74_nts_x86
                            <br/>
                            extension=sqlsrv_74_ts_x64
                            <br/>
                            extension=sqlsrv_74_ts_x86
                        </li>
                    </ul>
                    <br/>
                    <p>This is a php.ini file example. Look for the "Dynamic Extensions" section.</p>
                    <img style="border: 2px solid black" src="./img/php-ini-extension_addition_example.jpg"/>
                </li>
                <br/>
                <li>
                    Exit out of the php.ini file on xampp. Close xampp and re-open it under "Run as Administrator".
                    You should see a line of red X marks right next to each module. The red X mark means, the driver 
                    for that specific module isn't installed as shown in the image below.<br/>
                    <img src="./img/xampp-install-apache.jpg"/>
                </li>
                <li>
                    To install a module, click the red X next to the module of your choice and a window prompt will show. Click 
                    yes and a green check mark should appear. An example of this window prompt is shown below.<br/>
                    <img src="./img/install-apache-example.JPG"/>
                </li>
                <li>
                    Start the apache module and refresh your web-browser.
                    If all was done successfully, xampp shouldn't show any error messages when starting up apache.
                </li>
                <br/>
                <li>
                    Create a php file in your xampp/htdocs folder (different than index) and copy/paste this code in-between the php syntax.<img src="./img/php-syntax.JPG"/> This code will retrieve items from the database. 
<textarea style="width: 550px;height: 450px;">
function connectionString() {
    $username = "type-username-here";
    $password = "type-password-here";
    $database = "HelloWorld";
    // Assign $connectionInfo to array of key-value pairs
    $connectionInfo = array("UID" => $username,
                            "PWD" => $password,
                            "Database" => $database);
    // Connect to sql server using server name and array of key-value pairs to complete connection string.
    return sqlsrv_connect("aa4fbu4uhl27r3.coyntr3y4wn1.us-east-1.rds.amazonaws.com", $connectionInfo);
}
function select_DateTime() {
    try {
        $conn = connectionString();
            
        $sql = "select time from TimeStamp";
        // Query execute using sql server function.
        $stmt = sqlsrv_query($conn, $sql);
            
        if ($stmt === false):
            echo "Sql Server Error: " . sqlsrv_errors();
        else:
            // Make sure to add this line for the javascript.
            echo "$('#selectDateTime').click(function(){";
            // Assign sql results in array form to a $row variable.
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                // Using javascript, alert the user on the page, the record result.
                echo "alert('" . $row['time'] . "');";
            }
            // This is the closing brackets for the click function.
            // This must be added as well.
            echo "});";
        endif;
        // Close connection to database.
        sqlsrv_close($conn);
    } catch (Exception $e) {
        echo "<p>" . $e . "</p>";
    } catch (Throwable $ee) {
        echo "<p>" . $ee . "</p>";
    }
        
    }</textarea> 
                    <br/>
                    <img src="./img/SQL-Server-Code-Example.JPG"/>
                </li>
                <br/>
                <li>
                    Below the php syntax <img src="./img/php-syntax.JPG"/>, copy/paste these lines. This code will output strings in a alert window. <br/>
<textarea style="width: 400px;height: 250px;">
<!DOCTYPE html>
<html>
    <head></head>
    <!-- JQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        // Initialize JQuery
        $(document).ready(function() {
            // Call PHP function from above.
        });
    </script>
    <body>
        <button id="selectDateTime"><div><p>Select All Records</p></div></button>
    </body>
</html></textarea>
                <img src="./img/retrieve-db-records-code-example.JPG"/>
                </li>
                <br/>
                <li>Save and close your php file. Open your web-browser and type in "localhost/your-php-file-name.php". The webpage should appear.</li>
            </ol>
        </div>
    </body>
    
</html>