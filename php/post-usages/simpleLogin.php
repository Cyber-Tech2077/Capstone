<?php
    session_start();
    require_once '../DBConnect.php';

    $conn = databaseConnect('Pet');
    try {

        $query = 'select [password] from users where [username] = ?';
        $credentials = array();
        foreach ($_POST as $postKey => $postValue) {
            foreach (json_decode($postValue) as $userKey => $userPassValue) {
                switch (strtoupper($userKey)) {
                    case 'USERNAME':
                        array_push($credentials, $userPassValue);
                        break;
                }
            }
        }
        $stmt = sqlsrv_query($conn, $query, $credentials);
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
            foreach ($_POST as $postKey => $postValue) {
                $username;
                foreach (json_decode($postValue) as $key => $value) {
                    switch (strtoupper($key)) {
                        case 'USERNAME':
                            $username = $value;
                            break;
                        case 'PASSWORD':
                            if (password_verify($value, $row[0])) {
                                $_SESSION['currentUser'] = $username;
                                echo json_encode(array('successful' => 'Login successful.'));
                            }
                            break;
                    }
                }
            }
        }
    } catch (Exception $e) {
        return 'Exception: ' . $e;
    } catch (Throwable $ee) {
        return 'Throwable: ' . $ee;
    }
    sqlsrv_close($conn);


?>