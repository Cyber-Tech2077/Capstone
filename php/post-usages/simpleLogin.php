<?php
    require_once '../DBConnect.php';

    $conn = databaseConnect('Pet');
    try {

        $query = 'select username, password from users where username = ? AND password = ?';
        foreach ($_POST as $postKey => $postValue) {
            foreach (json_decode($postValue) as $key => $value) {
                $stmt = sqlsrv_prepare($conn, $query, $value);
            }
        }
        $execute = sqlsrv_execute($stmt);
        if ($execute) {
            echo json_encode(array('successful' => 'Your insert was successful!'));
        } else {
            return json_encode(array('error' => 'An error has sadly encountered. Please try again later.'));
        }
    } catch (Exception $e) {
        return 'Exception: ' . $e;
    } catch (Throwable $ee) {
        return 'Throwable: ' . $ee;
    }
    sqlsrv_close($conn);


?>