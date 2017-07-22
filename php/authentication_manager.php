<?php

	require_once('definitions.php');

	class AuthenticationManager
	{
		function isAppLoggedIn()
		{
			print "authentication_manager.php:14: isAppLogin Function is untested. Expect errors/warnings/malfunction.";
			return isset($_SESSION['uid'], $_SESSION['username'], $_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
		}

		function appLogout()
		{
			$ulogin->SetAutologin($_SESSION['username'], false);
			unset($_SESSION['uid']);
			unset($_SESSION['username']);
			unset($_SESSION['loggedIn']);
		}

		function authenticate($username, $password)
		{
			$returnArray = array('did_authenticate' => true, 'is_administrator' => true );
			return json_encode($returnArray);
		}

		function appLogin($uid, $username, $ulogin)
		{
			$_SESSION['uid'] = $uid;
			$_SESSION['username'] = $username;
			$_SESSION['loggedIn'] = true;
		}
	}

?>