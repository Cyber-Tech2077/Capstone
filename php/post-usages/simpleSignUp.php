<?php

	require_once '../DBConnect.php';

    $conn = databaseConnect('Pet');
    try {

        $query = 'insert into users (username, password, email) values (?,?,?)';
        $credentials = array();
        foreach ($_POST as $postKey => $postValue) {
            foreach (json_decode($postValue) as $key => $value) {
                switch (strtoupper($key)) {
                    case 'USERNAME':
                        array_push($credentials, $value);
                        break;
                    case 'PASSWORD':
                        array_push($credentials, password_hash($value, PASSWORD_BCRYPT));
                        break;
                    case 'EMAIL':
                        array_push($credentials, $value);
                        break;
                }
            }
        }
        $stmt = sqlsrv_prepare($conn, $query, $credentials);
        $execute = sqlsrv_execute($stmt);
        if ($execute) {
            echo json_encode(array('successful' => 'You have been successfully signed up. Please login with your credentials.'));
        } else {
            foreach (sqlsrv_errors() as $errorKey => $errorValue) {
                echo json_encode(array('error' => 'An error has sadly encountered. Please try again later.'));
            }
        }
    } catch (Exception $e) {
        return 'Exception: ' . $e;
    } catch (Throwable $ee) {
        return 'Throwable: ' . $ee;
    }
    sqlsrv_close($conn);

?>