<?php

	require_once('../lib/php/ulogin/config/all.inc.php');
	require_once('../lib/php/ulogin/main.inc.php');
	require_once('definitions.php');

	if (!sses_running())
	sses_start();

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
			$ulogin->Authenticate($username, $password);
			if ($ulogin->IsAuthSuccess()) {
				$returnArray = array('did_authenticate' => true );
				return json_encode($returnArray);
			} else {
				$returnArray = array('did_authenticate' => false );
				return json_encode($returnArray);
			}
		}

		function appLogin($uid, $username, $ulogin)
		{
			$_SESSION['uid'] = $uid;
			$_SESSION['username'] = $username;
			$_SESSION['loggedIn'] = true;
		}
	}

?>