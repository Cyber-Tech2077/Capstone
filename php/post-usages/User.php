<?php
	session_start();
	class User {
		function userSignOut($userMessage) {
			session_unset();
			session_destroy();
			return json_encode(array('logout' => $userMessage));
		}
	}
	if (isset($_POST)) {
		foreach ($_POST as $postKey => $postValue) {
			foreach (json_decode($postValue) as $key => $value) {
				switch (strtoupper($key)) {
					case 'LOGOUT':
						$userLogOut = new User();
						echo $userLogOut->userSignOut($value);
						break;
				}
			}
		}
	}
?>