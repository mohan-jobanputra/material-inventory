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
			print "core.php:11: isAppLogin Function is untested. Expect errors/warnings/malfunction.";
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
			$ulogin->Authenticate($_POST['user'],  $_POST['pwd']);
			if ($ulogin->IsAuthSuccess()) {
				return true;
			} else {
				return false;
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